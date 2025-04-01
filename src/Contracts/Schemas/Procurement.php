<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

interface Procurement extends DataManagement
{
    public function showUsingRelation(): array;
    public function getProcurement(): mixed;
    public function prepareShowProcurement(?Model $model = null, ?array $attributes = null): ?Model;
    public function showProcurement(?Model $model = null): array;
    public function prepareStoreProcurement(mixed $attributes = null): Model;
    public function prepareStoreProcurementItems(mixed $attributes = null): Model;
    public function storeProcurement(): array;
    public function prepareProcurementPaginate(mixed $cache_reference_type, ?array $morphs = null, int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): LengthAwarePaginator;
    public function viewProcurementPaginate(mixed $reference_type, ?array $morphs = null, int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): array;
    public function prepareMainReportProcurement(Model $procurement): Model;
    public function prepareReportProcurement(?array $attributes = null): Model;
    public function reportProcurement(): array;
    public function prepareDeleteProcurement(?array $attributes = null): bool;
    public function deleteProcurement(): bool;
    public function procurement(mixed $morphs = null, mixed $conditionals = null): Builder;
}
