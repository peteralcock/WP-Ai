<?php

namespace AIKit\Dependencies\Faker\Provider\pt_PT;

class Company extends \AIKit\Dependencies\Faker\Provider\Company
{
    protected static $formats = [
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{lastName}}',
        '{{lastName}} e {{lastName}}',
        '{{lastName}} {{lastName}} {{companySuffix}}',
        'Grupo {{lastName}} {{companySuffix}}',
    ];

    protected static $companySuffix = ['e Filhos', 'e Associados', 'Lda.', 'S.A.'];
}
