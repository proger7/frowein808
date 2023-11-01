jQuery(document).ready(function($) {

  var $table = $('#table')
  var $remove = $('#remove')
  var selections = []
  const myData = [
      {
        "id": 0,
        "name": "Equipment",
        "description": ""
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Werbeunterlagen",
        "description": ""
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      },
      {
        "id": 1,
        "name": "Katalog “Produkte”",
        "description": "Katalog"
      },
      {
        "id": 2,
        "name": "Preisliste aktuell (gultig ab 01/02/2021)",
        "description": "PL"
      },
      {
        "id": 3,
        "name": "Turbo-sprayer",
        "description": "Web-tur 2041"
      },
      {
        "id": 4,
        "name": "Contrax-D Koder",
        "description": "Web-tur 2041"
      },
      {
        "id": 5,
        "name": "Contrax-D Koder",
        "description": "Web-tur 204"
      },
      {
        "id": 6,
        "name": "HYGiTEC Permanent-Monitoring",
        "description": "Web-tur 2041"
      }
  ]

  function getIdSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
      return row.id
    })
  }


  function operateCheckbox(value, row, index) {
    return [
      '<label class="like">',
      '<input name="likeItem" class="form-check-input" type="checkbox">',
      '</label>  ',
    ].join('')
  }

  window.addCheckbox = {
    'click .like': function (e, value, row, index) {
      console.log(row.id);
    }
  }


  function totalNameFormatter(data) {
    return data.length
  }


  function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
      data: myData,
      pageSize: 28,
      paginationSuccessivelySize: 3,
      paginationPagesBySide: 1,
      columns: [
        [{
          field: 'id',
          title: 'Auswahlen',
          align: 'left',
          events: window.addCheckbox,
          formatter: operateCheckbox
        }, {
          field: 'name',
          title: 'Titel',
          sortable: true,
          footerFormatter: totalNameFormatter,
          align: 'left'
        }, {
          field: 'description',
          title: 'Bezeichnung',
          sortable: true,
          align: 'left'
        }]
      ]
    })
    $table.on('check.bs.table uncheck.bs.table ' +
      'check-all.bs.table uncheck-all.bs.table',
    function () {
      $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)

      // save your data, here just save the current page
      selections = getIdSelections()
      // push or splice the selections if you want to save all data selections
    })
    $table.on('all.bs.table', function (e, name, args) {
      console.log(name, args)
    })
    $remove.click(function () {
      var ids = getIdSelections()
      $table.bootstrapTable('remove', {
        field: 'id',
        values: ids
      })
      $remove.prop('disabled', true)
    })
  }


  $(function() {

    $(document).ready(function () {
      $table.bootstrapTable('mergeCells', {
        index: 0,
        field: 'id',
        colspan: 3,
        rowspan: 1,
      });

      $table.bootstrapTable('mergeCells', {
        index: 3,
        field: 'id',
        colspan: 3,
        rowspan: 1,
      }); 

      $(".bootstrap-table .fixed-table-container .table tr[data-index='0'] td[colspan]").append("Equipment").addClass("categoryHead");
      $(".bootstrap-table .fixed-table-container .table tr[data-index='3'] td[colspan]").append("Werbeunterlagen").addClass("categoryHead");

      var pathname = window.location.pathname;
      if( pathname == '/partner-info/' ) {
        $(".bootstrap-table .fixed-table-pagination>.pagination-detail .pagination-info").before('<input type="submit" class="bestellen" value="Bestellen">');  
      }
      
    });
  });

  $(function() {
    initTable();
  })

  $('#search-field-header').keyup(function () {
      var rex = new RegExp($(this).val(), 'i');
      $('#table tbody tr').hide();
      $('#table tbody tr').filter(function () {
          return rex.test($(this).text());
      }).show();
  })

});