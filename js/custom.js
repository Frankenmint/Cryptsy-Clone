var myScroll1, myScroll2, myScroll3, myScroll4;

$(document).ready(function(){  
        
   myScroll1 = new IScroll('#btc-markets', { scrollbars: true, mouseWheel: true, interactiveScrollbars: true }); 
   myScroll2 = new IScroll('#ltc-markets', { scrollbars: true, mouseWheel: true, interactiveScrollbars: true }); 
   myScroll3 = new IScroll('#doge-markets', { scrollbars: true, mouseWheel: true, interactiveScrollbars: true }); 
   myScroll4 = new IScroll('#account-balances', { scrollbars: true, mouseWheel: true, interactiveScrollbars: true }); 

	//START NOTIFICATION CLOSE
	$('.notification .close').click(function(){
		$(this).parent().parent().animate({top: '25px', opacity: 0}, 500, function() {
			$(this).slideUp();
  		});
	});
	//END NOTIFICATION CLOSE

   $('#markettable').dataTable( {
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "sScrollY": "565px",
		"aoColumns": [
			null,
			null,
		    { "sType": "alt-string" },
			null,
			null,
			null

		]
		

    } );
	
    
    
	jQuery.extend( jQuery.fn.dataTableExt.oSort, {
     
	    "alt-string-asc": function( a, b ) {
	    	a = parseFloat(a);
	    	b = parseFloat(b);
	        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
	    },
 
	    "alt-string-desc": function(a,b) {
	    	a = parseFloat(a);
	    	b = parseFloat(b);
	        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
	    }
	});

    
        $(".prettyselect").select2();
        $('.checkbox-inline input').prettyCheckable();

        $('#chat_tabs a').click(function (e) {
          e.preventDefault()
          $(this).tab('show')
        })
        
        $("#msglink").trigger("click");
    
});

$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    if ( sNewSource !== undefined && sNewSource !== null ) {
        oSettings.sAjaxSource = sNewSource;
    }
 
    // Server-side processing should just call fnDraw
    if ( oSettings.oFeatures.bServerSide ) {
        this.fnDraw();
        return;
    }
 
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];
 
    this.oApi._fnServerParams( oSettings, aData );
 
    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable( oSettings );
 
        /* Got the data - add it to the table */
        var aData =  (oSettings.sAjaxDataProp !== "") ?
            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
 
        for ( var i=0 ; i<aData.length ; i++ )
        {
            that.oApi._fnAddData( oSettings, aData[i] );
        }
         
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
 
        that.fnDraw();
 
        if ( bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd( oSettings );
            that.fnDraw( false );
        }
 
        that.oApi._fnProcessingDisplay( oSettings, false );
 
        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback !== null )
        {
            fnCallback( oSettings );
        }
    }, oSettings );
};
