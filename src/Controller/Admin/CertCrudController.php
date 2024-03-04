<?php

namespace App\Controller\Admin;

use App\Entity\Cert;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cert::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
           TextField::new('NomP'),
            TextField::new('IDP'),
         TextField::new('NomM'),
            TextField::new('Date'),

            TextEditorField::new('Description'),
        ];
    }

}
