<?php

namespace Noxo\FilamentActivityLog\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Tables\Enums\PaginationMode;
use Livewire\WithPagination;
use Noxo\FilamentActivityLog\Pages\Concerns\CanPaginate;
use Spatie\Activitylog\Models\Activity;

abstract class ListActivities extends Page implements HasSchemas
{
    use CanPaginate;
    use Concerns\CanCollapse;
    use Concerns\HasListFilters;
    use Concerns\HasLogger;
    use Concerns\UrlHandling;
    use InteractsWithSchemas;
    use WithPagination {
        WithPagination::resetPage as resetLivewirePage;
    }

    protected string $view = 'filament-activity-log::list.index';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-s-finger-print';

    public function getTitle(): string
    {
        return __('filament-activity-log::activities.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-activity-log::activities.title');
    }

    public function mount(): void
    {
        $this->fillFilters();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make()
                    ->compact()
                    ->columns(5)
                    ->schema([
                        $this->getDateRangeField(),
                        $this->getCauserField(),
                        $this->getSubjectTypeField(),
                        $this->getSubjectIDField(),
                        $this->getEventField(),
                    ]),
            ])
            ->debounce();
    }

    public function getPaginationMode(): PaginationMode
    {
        return PaginationMode::Default;
    }

    public function getActivities()
    {
        $activityModel = config('activitylog.activity_model') ?? Activity::class;

        return $this->paginateQuery(
            $this->applyFilters($activityModel::with('causer')->latest())
        );
    }

    protected function getIdentifiedTableQueryStringPropertyNameFor(string $property): string
    {
        return $property;
    }

    protected function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 10;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50];
    }
}
