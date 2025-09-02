@if (!empty($value))
    @php
        $fields = $field->table->getFields();
        $isHtmlAllowed = $field->isHtmlAllowed();
    @endphp

    <div class="w-full overflow-x-auto border border-gray-200 dark:border-white/5 rounded-lg">
        <table class="fi-ta-table">
            <thead>
                <tr>
                    @foreach ($fields as $field)
                        <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 !p-2">
                            {{ $field->getLabel() }}
                        </th>
                    @endforeach
                </tr>
            </thead>


            @foreach ($value as $item)
                <tr
                    class="fi-ta-row fi-ta-row-not-reorderable"
                >
                    @foreach ($fields as $field)
                        <td class="fi-ta-cell first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 p-2 align-top">
                            @php
                                $rawValue = $item[$field->name] ?? data_get($item, $field->name);
                                $dispayValue = $field->display($rawValue);
                            @endphp

                            @if ($isHtmlAllowed)
                                {!! $dispayValue !!}
                            @else
                                {{ $dispayValue }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
@endif
