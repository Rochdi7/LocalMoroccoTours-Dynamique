{{--
    Shared client-side datatable enhancer.

    Turns any admin index <table id="pc-dt-simple"> into a searchable, paginated,
    sortable table using the theme's bundled simple-datatables library — no page
    refresh. The library injects its own .datatable-top (per-page selector +
    "Search..." box) and .datatable-bottom (pagination), styled by the theme CSS.

    Requirements for the table:
      - has id="pc-dt-simple"
      - all rows rendered in the DOM (controller returns ->get(), not ->paginate())

    Columns whose header text is "Image" or "Actions" are made non-sortable and
    excluded from search automatically.
--}}
<script src="{{ URL::asset('build/js/plugins/simple-datatables.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var table = document.getElementById('pc-dt-simple');
        if (!table || typeof simpleDatatables === 'undefined') {
            return;
        }

        // Build per-column options from the header text so button/image columns
        // are not sortable and are kept out of the search index.
        var headers = table.querySelectorAll('thead th');
        var columns = [];
        headers.forEach(function (th, index) {
            var label = (th.textContent || '').trim().toLowerCase();
            if (label === 'image' || label === 'actions' || label === 'action') {
                columns.push({ select: index, sortable: false, searchable: false });
            }
        });

        new simpleDatatables.DataTable(table, {
            searchable: true,
            fixedHeight: false,
            perPage: 10,
            perPageSelect: [5, 10, 15, 20, 25, 50],
            columns: columns,
            labels: {
                placeholder: 'Search...',
                searchTitle: 'Search within table',
                perPage: 'entries per page',
                noRows: 'No entries found',
                noResults: 'No results match your search',
                info: 'Showing {start} to {end} of {rows} entries'
            }
        });
    });
</script>
