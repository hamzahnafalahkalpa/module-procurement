<?php

namespace Hanafalah\ModuleProcurement\Enums\Procurement;

enum Status: string
{
    case DRAFT    = 'DRAFT';
    case REPORTED = 'REPORTED';
    case CANCELED = 'CANCELED';
}
