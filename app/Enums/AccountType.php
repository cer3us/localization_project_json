<?php

namespace App\Enums;

enum AccountType: String
{
    case LTD = 'ltd';
    case Freelancer = 'freelancer';
    case Individual = 'individual';
}
