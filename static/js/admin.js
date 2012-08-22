function copytorss(url) {
	if(!/^https?:\/\/./.test(url)) {
		url = "http://" + url;
		$("#input02").val(url);
	}
	
	if(!/\/$/.test(url)) {
		url += '/';
		$("#input02").val(url);
	}
		
	if($("#input03").val().length == 0) {
	
		if(/blogspot./.test(url)) {
			$("#input03").val(url + 'feeds/posts/default');
		}
		else {
			$("#input03").val(url + 'feed/');
		}
	}
}

function deleteblog(id) {

	if(confirm("Are you sure you want to delete blog #" + id + "?")) {

		$.get('<?= config("basepath"); ?>/admin/deleteblog/?id=' + id, function(data) {
	
			if(data == 200) {	
				$("#blog" + id).slideUp('fast');
			}
		});
	}
}

function undeleteblog(id) {

	$.get('<?= config("basepath"); ?>/admin/restoreblog/?id=' + id, function(data) {
	
		if(data == 200) {	
			$("#blog" + id).slideUp('fast');
		}
	});
}

function quicksearch(str) {

    var table = document.getElementById("bloglist");

    var terms = str.toLowerCase().split(" ");

    for (var r = 1; r < table.rows.length; r++) {
	    var display = '';
	    for (var i = 0; i < terms.length; i++) {
		    if (table.rows[r].innerHTML.replace(/<[^>]+>/g, "").toLowerCase()
			    .indexOf(terms[i]) < 0) {
			    display = 'none';
		    }
		    table.rows[r].style.display = display;
	    }
    }
}
