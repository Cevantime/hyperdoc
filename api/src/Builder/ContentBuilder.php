<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 21/11/18
 * Time: 22:53
 */

namespace App\Builder;

use App\Entity\Content;
use App\Entity\ContentAssociation;
use App\Entity\ContentValue;
use App\Entity\ValueInjection;
use App\Repository\ContentRepository;
use App\Repository\ProgramRepository;
use Middlewares\HttpErrorException;
use Psr\Http\Message\ServerRequestInterface;
use Sherpa\Rest\Validator\InputBag;

class ContentBuilder
{
    // [[ma_valeur]]
    const VAR_REGEX = '/\\[\\[([a-zA-Z0-9_]+)\\]\\]/';

    // [%mon-program:mon_input(ma_valeur):mon_autre_input(mon_autre_valeur)%]
    const PROGRAM_REGEX = '/\\[\\%(.+?)\\%\\]/';
    
    protected $valueBuilder;
    protected $contentRepo;
    protected $locale;

    public function __construct(ContentValueBuilder $valueBuilder, ContentRepository $contentRepo, ServerRequestInterface $request)
    {
        $this->valueBuilder = $valueBuilder;
        $this->contentRepo = $contentRepo;
        $this->locale = $request->getHeaderLine('Accept-Language');
    }
    
    protected function save(InputBag $data, Content $content)
    {
        $translation = $content->translate($this->locale);

        foreach (['title', 'description'] as $key) {
            if (isset($data[$key])) {
                $translation->{'set' . ucfirst($key)}($data[$key]);
            }
        }

        if (isset($data['inputs']) && is_array($data['inputs'])) {
            foreach ($data['inputs'] as $input) {
                $input = new InputBag($input);
                if( ($contentInput = $content->getInputByName($input['name']))) {
                    $this->valueBuilder->update($input, $contentInput);
                } else {
                    $content->addInput($this->valueBuilder->build($input));
                }
            }
        }

        $content->mergeNewTranslations();
        $this->parseInputs($content);
        $this->parseWrapped($content);
        $this->generateFullContent($content);
        $this->generateAssociatedInputs($content);
    }

    protected function parseInputs(Content $content)
    {
        $inputs = $content->getInputs()->toArray();
        $inputNames = array_map(function (ContentValue $input) {
            return $input->getName();
        }, $inputs);
        $inputs = array_combine($inputNames, $inputs);
        $rawCode = $content->getOwnContent();
        preg_match_all(self::VAR_REGEX, $rawCode, $matched);
        $parsedNames = array_unique($matched[1]);
        $content->getInputs()->clear();

        foreach ($parsedNames as $parsedName) {
            $content->addInput($inputs[$parsedName] ?? (new ContentValue())->setName($parsedName));
        }
    }

    protected function parseWrapped(Content $content)
    {
        $wrapped = $content->getWrapped()->toArray();
        $contentSlugs = array_map(function (ContentAssociation $wrapped) {
            return $wrapped->getWrappedContent()->getSlug();
        }, $wrapped);
        $wrapped = array_combine($contentSlugs, $wrapped);
        $rawCode = $this->generateFullyQualifiedContent($content);
        preg_match_all(self::PROGRAM_REGEX, $rawCode, $matched);
        $content->getWrapped()->clear();

        foreach ($matched[1] as $parsedWrapped) {
            $segments = explode(':', $parsedWrapped);
            $parsedSlug = array_shift($segments);
            if(isset($wrapped[$parsedSlug])) {
                $wrappedAssociation = $wrapped[$parsedSlug];
            } else {
                $associatedContent = $this->contentRepo->getContentBySlug($parsedSlug);
                if(! $associatedContent) {
                    throw new HttpErrorException(sprintf('Invalid associated content : content with slug "%s" does not exist', $parsedSlug), 400);
                }
                $wrappedAssociation = (new ContentAssociation())->setWrappedContent($associatedContent);
            }

            $wrappedAssociation->getInjections()->clear();

            $inputs = $wrappedAssociation->getWrappedContent()->getInputs()->toArray();
            $inputNames = array_map(function ($input) {
                return $input->getName();
            }, $inputs);
            $inputs = array_combine($inputNames, $inputs);

            foreach ($segments as $segment) {
                if (preg_match('/([a-zA-Z0-9\-]+?)\\((.+?)\\)/', $segment, $matches)) {
                    $inputName = $matches[1];
                    if (isset($inputs[$inputName])) {
                        $valueInjection = (new ValueInjection())
                            ->setValue($matches[2])
                            ->setContentValue($inputs[$inputName]);
                        $wrappedAssociation->addInjection($valueInjection);
                    }
                }
            }

            $content->addWrapped($wrappedAssociation);
        }
    }

    protected function generateAssociatedInputs(Content $content)
    {
        $content->getAssociatedInputs()->clear();
        foreach ($content->getWrapped() as $wrappedAssociation) {
            $wrappedContent = $wrappedAssociation->getWrappedContent();
            $wrappedContentInputs = $wrappedContent->getAllInputs()->toArray();
            $wrappedContentInputNames = array_map(function (ContentValue $input) {
                return $input->getId();
            }, $wrappedContentInputs);
            $wrappedContentInputs = array_combine($wrappedContentInputNames, $wrappedContentInputs);
            foreach ($wrappedAssociation->getInjections() as $injection) {
                unset($wrappedContentInputs[$injection->getContentValue()->getId()]);
            }
            foreach ($wrappedContentInputs as $input) {
                $content->addAssociatedInput($input);
            }
        }
    }

    protected function generateFullContent(Content $content)
    {
        // [%mon-program:mon_input(ma_valeur):mon_autre_input(mon_autre_valeur)%]
        $code = $this->generateFullyQualifiedContent($content);
        $wrappedAssociations = $content->getWrapped();

        foreach ($wrappedAssociations as $wrappedAssociation) {
            $wrappedContent = $wrappedAssociation->getWrappedContent();
            $slug = $wrappedContent->getSlug();
            $code = preg_replace('/\\[\\%' . preg_quote($slug) . '(:.+?)*\\%\\]/', $wrappedContent->getFullContent(), $code, 1);
            foreach ($wrappedAssociation->getInjections() as $injection) {
                $code = str_replace('[[' . $slug . '@' . $injection->getContentValue()->getName() . ']]', $injection->getValue(), $code);
            }
        }

        $content->setFullContent($code);

        foreach($content->getWrappers() as $wrapper) {
            $wrapperContent = $wrapper->getWrapperContent();
            $this->generateFullContent($wrapperContent);
        }
    }

    protected function generateFullyQualifiedContent(Content $content)
    {
        $code = $content->getOwnContent();
        $inputs = $content->getInputs();
        $slug = $content->getSlug();
        foreach ($inputs as $input) {
            $code = str_replace(sprintf('[[%s]]', $input->getName()), '[[' . $slug . '@' . $input->getName() . ']]', $code);
        }
        return $code;
    }
}