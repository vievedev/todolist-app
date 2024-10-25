    </main>
    <script src="<?=ASSETS?>js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?=ASSETS?>datatables/jquery-3.7.1.js"></script>
    <script src="<?=ASSETS?>datatables/dataTables.js"></script>
    <script src="<?=ASSETS?>datatables/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#userTasksTable', {
                pageLength: 2, // Default number of rows to display
                lengthMenu: [2, 5, 10] // Options for the dropdown
            });
        });
    </script>
    </body>
</html>