<table class="fi-ta-table w-full overflow-hidden text-sm !table-fixed">
    <thead>
        <td
            width="20%"
            class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 !py-2"
        >
            @lang('filament-activity-log::activities.table.field')
        </td>
        <td
            width="40%"
            class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 !py-2"
        >
            @lang('filament-activity-log::activities.table.old')
        </td>
        <td
            width="40%"
            class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 !py-2"
        >
            @lang('filament-activity-log::activities.table.new')
        </td>
    </thead>

    @foreach ($changes['attributes'] as $key => $newValue)
        @php
            $field = $logger->getFieldByName($key);
            if (!$field) {
                continue;
            }

            $oldValue = $changes['old'][$key] ?? null;

            if($field->display($oldValue, raw: true) === $field->display($newValue, raw: true)) {
                // Skip display if it's the same value.
                continue;
            }
        @endphp

        <tr class="fi-ta-row fi-ta-row-not-reorderable">
            <td class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 px-4 py-2 align-top sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                {{ $field->getLabel() }}
            </td>

            @if ($field->is('difference'))
                <td
                    colspan="2"
                    class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 px-4 py-2 align-top sm:first-of-type:ps-6 sm:last-of-type:pe-6 break-all !whitespace-normal"
                >
                    {{ view('filament-activity-log::components.difference', [
                        'options' => $field->options,
                        'oldValue' => $field->display($oldValue, raw: true),
                        'newValue' => $field->display($newValue, raw: true),
                    ]) }}
                </td>
            @else
                <td class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 px-4 py-2 align-top sm:first-of-type:ps-6 sm:last-of-type:pe-6 overflow-x-auto">
                    {{ $field->display($oldValue) }}
                </td>

                <td class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 px-4 py-2 align-top sm:first-of-type:ps-6 sm:last-of-type:pe-6 overflow-x-auto">
                    {{ $field->display($newValue) }}
                </td>
            @endif

        </tr>
    @endforeach
</table>
