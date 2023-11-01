jQuery(document).ready(function($) {

  var pathname = window.location.pathname.replace('/', '');
  if( pathname == 'partner-overview' ) {
    $(".bootstrap-table.bootstrap5 .float-left .bestellen").css('display', 'none');
  }

  var produktTitle = 'Produkt-' + '<br>' + ' Information';
  var safetyTitle = 'Sicherheits-' + '<br>' + ' Datenblatt';
  var guideTitle = 'Geberbrauchs-' + '<br>' + ' anweisung';

  var $table = $('#table-overview')
  var $remove = $('#remove')
  var selections = []
  const myData = [
      {
        "article": "Equipment",
        "type": "",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Spruhmittel/Spraying products (10 Liter)",
        "type": "",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      },
      {
        "article": "Pistolenadapter fur Aerosoldose 100 ml/200 ml",
        "type": "Deutsch",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }, 
      {
        "article": "Detmol-BIO.A L",
        "type": "English",
        "information": 0,
        "safetydata": 0,
        "userguide": 0
      },
      {
        "article": "Detmol-pheno (AE)",
        "type": "English",
        "information": 1,
        "safetydata": 1,
        "userguide": 1
      }
  ]

  function getIdSelections() {
    return $.map($table.bootstrapTable('getSelections'), function (row) {
      return row.id
    })
  }

  function operateFormatter(value, row, index) {
    return [
      '<a class="download" href="javascript:void(0)" title="Download">',
      '<img src="/images/partner/table/downloadicon.svg">',
      '</a>  ',
      '<a class="view" href="javascript:void(0)" title="View">',
      '<img src="/images/partner/table/viewicon.svg">',
      '</a>'
    ].join('')
  }

  window.operateEvents = {
    'click .download': function (e, value, row, index) {
      alert('You click download action doc with name: ' + JSON.stringify(row.article))
    },
    'click .view': function (e, value, row, index) {
      alert('You click view action doc with data: ' + JSON.stringify(row))
    }
  }

  function totalNameFormatter(data) {
    return data.length
  }


  function initTable() {
    $table.bootstrapTable('destroy').bootstrapTable({
      data: myData,
      pageSize: 22,
      paginationSuccessivelySize: 3,
      paginationPagesBySide: 1,
      columns: [
        [{
          field: 'article',
          title: 'Artikel',
          sortable: true,
          footerFormatter: totalNameFormatter,
          align: 'left'
        }, {
          field: 'type',
          title: 'Typ',
          sortable: true,
          align: 'left'
        }, {
          field: 'information',
          title: produktTitle,
          sortable: false,
          align: 'left',
          events: window.operateEvents,
          formatter: operateFormatter
        }, {
          field: 'safetydata',
          title: safetyTitle,
          sortable: false,
          align: 'left',
          events: window.operateEvents,
          formatter: operateFormatter
        }, {
          field: 'userguide',
          title: guideTitle,
          sortable: false,
          align: 'left',
          events: window.operateEvents,
          formatter: operateFormatter,
          width: '50px'
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
        field: 'article',
        colspan: 5,
        rowspan: 1,
      });
      $table.bootstrapTable('mergeCells', {
        index: 2,
        field: 'article',
        colspan: 5,
        rowspan: 1,
      });

      $("#table-overview tr[data-index='0'] td[colspan]").addClass("categoryOverviewHead");
      $("#table-overview tr[data-index='2'] td[colspan]").addClass("categoryOverviewHead");

    });
  });

  $(function() {
    initTable();
  })

  $('#search-overview-header').keyup(function () {
      var rex = new RegExp($(this).val(), 'i');
      $('#table-overview tbody tr').hide();
      $('#table-overview tbody tr').filter(function () {
          return rex.test($(this).text());
      }).show();
  })

});