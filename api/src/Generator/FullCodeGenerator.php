<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 12/10/18
 * Time: 19:30
 */

namespace App\Generator;


use App\Entity\Program;
use App\Entity\ProgramValue;

class FullCodeGenerator
{
    public function generateFullCode(Program $program)
    {
        // [%mon-program:mon_input(ma_valeur):mon_autre_input(mon_autre_valeur)%]
        $code = $this->generateFullyQualifiedCode($program);
        $wrappedAssociations = $program->getWrapped();

        foreach ($wrappedAssociations as $wrappedAssociation) {
            $wrappedProgram = $wrappedAssociation->getWrappedProgram();
            $slug = $wrappedProgram->getSlug();
            $code = preg_replace('/\\[\\%' . preg_quote($slug) . '(:.+?)*\\%\\]/', $wrappedProgram->getFullCode(), $code, 1);
            foreach ($wrappedAssociation->getInjections() as $injection) {
                $code = str_replace('[[' . $slug . '@' . $injection->getProgramValue()->getName() . ']]', $injection->getValue(), $code);
            }
        }

        $program->setFullCode($code);
    }

    public function generateFullyQualifiedCode(Program $program)
    {
        $code = $program->getCode();
        $inputs = $program->getInputs();
        $slug = $program->getSlug();
        foreach ($inputs as $input) {
            $code = str_replace(sprintf('[[%s]]', $input->getName()), '[[' . $slug . '@' . $input->getName() . ']]', $code);
        }
        return $code;
    }
}