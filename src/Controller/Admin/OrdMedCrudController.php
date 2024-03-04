<?php

namespace App\Controller\Admin;

use App\Entity\OrdMed;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Config\Twig\NumberFormatConfig;

class OrdMedCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrdMed::class;
    }



    public function configureFields(string $pageName): iterable
    {
        return [
           // IdField::new('id'),
            TextField::new('NomP'),
            NumberField::new('IDP'),
            TextField::new('NomM'),

            TextEditorField::new('description'),
        ];
    }

}
