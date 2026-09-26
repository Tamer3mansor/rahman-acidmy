{{--
    Shared "where do I go" table for the admin documentation pages.

    Expects:
      $rows       array<int, array{element: string, path: string, note: string}>
      $firstHeader string  heading of the first column
--}}
<div class="overflow-x-auto">
    <table class="w-full divide-y divide-[var(--brand-border)] text-right text-sm text-[var(--brand-text-muted)]">
        <thead class="bg-[var(--brand-chip-bg)] text-[var(--brand-text)] font-semibold">
            <tr>
                <th class="px-4 py-3">{{ $firstHeader }}</th>
                <th class="px-4 py-3">المسار في لوحة التحكم</th>
                <th class="px-4 py-3">ملاحظة توضيحية</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[var(--brand-border)]">
            @foreach ($rows as $row)
                <tr>
                    <td class="px-4 py-3 font-medium text-[var(--brand-text)]">{{ $row['element'] }}</td>
                    <td class="px-4 py-3">
                        <span class="rounded-md bg-[var(--brand-chip-bg)] px-2.5 py-1 text-xs font-semibold text-[var(--brand-chip-text)]">{{ $row['path'] }}</span>
                    </td>
                    <td class="px-4 py-3 text-xs">{{ $row['note'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
