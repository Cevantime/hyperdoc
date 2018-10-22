<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 22/09/18
 * Time: 18:13
 */

namespace App\Builder;

use App\Entity\Content;
use App\Entity\Program;
use App\Repository\ProgramRepository;
use Cocur\Slugify\Slugify;
use Psr\Http\Message\ServerRequestInterface;
use Sherpa\Rest\Builder\RestBuilderInterface;
use Sherpa\Rest\Validator\InputBag;

class ProgramBuilder extends ContentBuilder implements RestBuilderInterface
{
    public function build(InputBag $data)
    {
        $program = new Program();
        $program->setSlug($data['language'] . '-' . (new Slugify())->slugify($data['title']));
        $this->save($data, $program);
        return $program;
    }

    public function update(InputBag $data, $program)
    {
        $this->save($data, $program);
    }

    public function save(InputBag $data, Content $program)
    {
        foreach (['code', 'language'] as $key) {
            if (isset($data[$key])) {
                $program->{'set' . ucfirst($key)}($data[$key]);
            }
        }
        parent::save($data, $program);
    }
}