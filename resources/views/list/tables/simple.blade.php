<table class="fi-ta-table w-full overflow-hidden text-sm !table-fixed">
    <thead>
        <td
            width="20%"
            class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 !py-2"
        >
            @lang('filament-activity-log::activities.table.field')
        </td>
        <td
            width="80%"
            class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 !py-2"
        >
            @lang('filament-activity-log::activities.table.value')
        </td>
    </thead>

    @foreach ($changes['attributes'] as $key => $value)
        @php
            $field = $logger->getFieldByName($key);
            if (!$field) {
                continue;
            }
        @endphp

        <tr class="fi-ta-row fi-ta-row-not-reorderable">
            <td class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 px-4 py-2 align-top sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                {{ $field->getLabel() }}
            </td>

            <td class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 px-4 py-2 align-top overflow-x-auto">
                {{ $field->display($value) }}
            </td>
        </tr>
    @endforeach
</table>
