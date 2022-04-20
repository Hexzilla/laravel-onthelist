function initDataTable(tableId, options) {
  const table = $('#' + tableId).DataTable({
    createdRow: function ( row, data, index ) {
        $(row).addClass('selected')
    },
    ...options,
  });

  table.on('click', 'tbody tr', function() {
      var $row = table.row(this).nodes().to$();
      var hasClass = $row.hasClass('selected');
      if (hasClass) {
          $row.removeClass('selected')
      } else {
          $row.addClass('selected')
      }
  })

  table.rows().every(function() {
      this.nodes().to$().removeClass('selected')
  });
}