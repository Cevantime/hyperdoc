<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 18:13
 */

namespace App\Builder;

use App\Entity\Program;
use App\Entity\ProgramValue;
use App\Repository\ProgramRepository;
use Cocur\Slugify\Slugify;
use Sherpa\Rest\Builder\RestBuilderInterface;

class ProgramBuilder implements RestBuilderInterface
{
    public function build(array $data, $locale = '')
    {
        $program = new Program();

        $program->setSlug((new Slugify())->slugify($data['title']));

        $this->save($data, $program, $locale);

        return $program;
    }

    public function update(array $data, $program, $locale = '')
    {
        $this->save($data, $program, $locale);
    }

    public function save(array $data, $program, $locale = '')
    {
        $translation = $program->translate($locale);
        foreach (['title', 'description'] as $key) {
            if (isset($data[$key])) {
                $translation->{'set' . ucfirst($key)}($data[$key]);
            }
        }
        foreach (['code', 'language'] as $key) {
            if (isset($data[$key])) {
                $program->{'set' . ucfirst($key)}($data[$key]);
            }
        }
        if (isset($data['inputs']) && is_array($data['inputs'])) {
            $valueBuilder = new ProgramValueBuilder();
            foreach ($data['inputs'] as $input) {
                $programValue = $valueBuilder->build($input);
                $program->addInput($programValue);
            }
        }
        $program->mergeNewTranslations();
    }
}