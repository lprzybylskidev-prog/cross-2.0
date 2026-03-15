<?php

declare(strict_types=1);

namespace App\Filament\Resources\Pages;

use App\Models\Contracts\ResolvesCompositeFilamentRecord;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ManageRecords;

abstract class ReadOnlyManageRecords extends ManageRecords
{
    protected function resolveTableRecord(?string $key): Model|array|null
    {
        if ($key === null) {
            return null;
        }

        /** @var class-string<Model> $modelClass */
        $modelClass = static::getResource()::getModel();

        if (!is_subclass_of($modelClass, ResolvesCompositeFilamentRecord::class)) {
            return parent::resolveTableRecord($key);
        }

        $query = $this->applyFiltersToTableQuery(
            $this->getTable()->getQuery(isResolvingRecord: true),
            isResolvingRecord: true,
        );

        foreach ($this->getTable()->getVisibleColumns() as $column) {
            $column->applyRelationshipAggregates($query);
        }

        return $modelClass::resolveFilamentRecord($query, $key);
    }
}
