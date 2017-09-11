$(document).ready(function(){
	$('.contarea>p').dotdotdot();
});
$(document).ready(function(){
	if($('.contarea').height()<$(window).height()){
		//$('.contwrap').addClass('fullh');
        //var dontMissThis ="ct.f/yougotthis.html";
	}else{
		$('.contwrap').removeClass('fullh');
	}
});
$(document).ready(function () {
	$('.ldbtn').click(function () {
        var pid = $('#morep').val();
        $.ajax({url:"/user/getMore/",
		        type: "get",
			    dataType: "html",
			    data: {id : pid},
			success: function (data) {
        	$('#remove').remove();
				$('.contcontain').append(data);
                if($('#remove').length == 0){
                    $('.ldbtn').remove()
                }
            }
		})
    });
});
$(document).ready(function () {

    $('.tldbtn').click(function () {
        var pid = $('#morep').val();
        $.ajax({url:"/admin/getMore/",
            type: "get",
            dataType: "html",
            data: {id : pid},
            success: function (data) {
                $('#remove').remove();
                $('.contcontain').append(data);
                if($('#remove').length == 0){
                    $('.tldbtn').remove()
                }
            }
        })
    });
});