$(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");;
    });

jQuery(document).ready(function() {
	searchicon()
	selectdrop()
    
	$('.mobile').click(function () {
    	$('nav').toggleClass('active'); 
    });
  
    $('nav ul li ul').each(function() {
    	$(this).before('<span class=\"arrow\"></span>');
    });
  
    $('nav ul li').click(function() {
   		$(this).children('ul').toggleClass('active');
     	$(this).children('.arrow').toggleClass('rotate');
    });

	$('.updown').click(function() {
		$('.notifications').slideToggle('slow', function() {
		$('.minus').toggleClass('pluse');
	    });
	});

	$('.detailsopen').click(function() {
		$('.details_options ul').slideToggle('slow', function() {
		$('.plus').toggleClass('minus');
	    });
	});

	// Build the chart
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: true,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: false
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Principal',
                color: '#ff7825',
                y: 56.33
            }, {
                name: 'Interest',
                color: '#44b0ee',
                y: 24.03
            }, {
                name: 'Others',
                color: '#1c5c99',
                y: 12.38
            }, {
                name: 'Resolving',
                color: '#808468',
                y: 7.26
            },]
        }]
    });

	$('.total_outstanding').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: true,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: false
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Principal',
                color: '#ff7825',
                y: 56.33
            }, {
                name: 'Interest',
                color: '#44b0ee',
                y: 24.03
            }, {
                name: 'Others',
                color: '#1c5c99',
                y: 12.38
            }, {
                name: 'Resolving',
                color: '#808468',
                y: 7.26
            },]
        }]
    });

	$('.total_repayments').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: true,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: false
            }
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Principal',
                color: '#ff7825',
                y: 56.33
            }, {
                name: 'Interest',
                color: '#44b0ee',
                y: 24.03
            }, {
                name: 'Others',
                color: '#1c5c99',
                y: 12.38
            }, {
                name: 'Resolving',
                color: '#808468',
                y: 7.26
            },]
        }]
    });

	var table = $('#gold_loan_view_details').DataTable( {
        
        "paging": true,
        "oLanguage": {
         "sSearch": "Find an Account:"
       }
    });

    var table = $('#statement_details').DataTable( {
        "paging": false,
         searching: false
    });

    var table = $('#payment_history').DataTable( {
        paging: false,
        info:false,
         searching: false,
         ordering:false
    });

    var table = $('#outstanding').DataTable( {
        paging: false,
        info:false,
         searching: false,
         ordering:false
    });

    var table = $('#repay_schedule').DataTable( {
        paging: false,
        info:false,
         searching: false,
         ordering:false
    });

    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
        var column = table.column( $(this).attr('data-column') );
        column.visible( ! column.visible() );
    });

    $('#gold_loan_view_details tbody').on('click', '.plus', function () {
        var tr = $(this).closest('tr');
        var content = tr.find('.acc_content_details').html();
        var row = table.row( tr );
        
	 	if (tr.hasClass('active')){
	 		tr.removeClass('active');
	 		tr.next().remove();
	 	} else {
	 		tr.after( '<tr class="active_content"><td colspan="4"><div class="acc_content_details">'+ content + '</div></td></tr>' );
	 		tr.addClass('active');
        }
        //$(".datepickerstatfrom,.datepickerstatto").datepicker();
 	});
    $(".datepickerfrom,.datepickerto").datepicker();
});

function searchicon(){
	$('input').blur(function(){
	  if( !$(this).val() == "" ){
		$(this).addClass('stay');
	  } else {
		$(this).removeClass('stay');
	  }
	});
	$('input').focus(function(){
		$(this).addClass('stay');
	});
}

function clearText(a) {
	if (a.defaultValue == a.value) {
		a.value = ""
		$(this).addClass("search_icon");
	} else {
		if (a.value == "") {
			a.value = a.defaultValue
			$(this).removeClass("search_icon");
		}
	}
}

function selectdrop(){
	 /*Select code*/
	$(".selectbg select").each(function(){
		$(this).children("option").each(function(){
			if($(this).attr("selected"))
			{
				$(this).parent().prev(".selectedvalue").html($(this).html());	
			}
		});
	});	
	$(".selectbg select").bind('change', function(){
		$(this).prev().html($(this).find('option:selected').text());
					
	});
	/*Select code*/
}


$( function() {

    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 3
        })

        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 3
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );