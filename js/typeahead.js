
function doSearch(people) {
	var query = $("#newAdmin").val();
	$("#newAdmin").removeAttr("aria-activedescendant");
	//$('#hint').val('');

	if ($("#newAdmin").val().length >= 2) {

		//Case insensitive search and return matches to build the  array
		var results = $.grep(people, function(item) {
			return item.search(RegExp("^" + query, "i")) != -1;

		});

		if (results.length >= 1) {
			$("#res").remove();
			$('#announce').empty();
			$(".autocomplete-suggestions").show();
			$(".autocomplete-suggestions").append('<div id="res" role="listbox" tabindex="-1"></div>');
			counter = 1;
		}

		//Bind click event to list elements in results
		$("#res").on("click", "div", function() {
			$("#newAdmin").val($(this).text());
			$("#res").remove();
			$('#announce').empty();
			$(".autocomplete-suggestions").hide();
			counter = 1;

		});

		//Add results to the list
		for (term in results) {

			if (counter <= 5) {
				$("#res").append("<div role='option' tabindex='-1' class='autocomplete-suggestion' id='suggestion-" + counter + "'>" + results[term] + "</div>");
				counter = counter + 1;
			}

		}
		var number = $("#res").children('[role="option"]').length
		if (number >= 1) {
			$("#announce").text(+number + " suggestions found" + ", to navigate use up and down arrows");
		}

	} else {
		$("#res").remove()
		$('#announce').empty();
		$(".autocomplete-suggestions").hide();
	}

}

function doKeypress(keys, event) {
	var highligted = false;
	highligted = $('#res').children('div').hasClass('highligt');
	switch (event.which) {

		case keys.ESC:
			$("#newAdmin").removeAttr("aria-activedescendant");
			//$('#hint').val('');
			$("#res").remove();
			$('#announce').empty();
			$(".autocomplete-suggestions").hide();
			break;

		case keys.RIGHT:

			return selectOption(highligted)
			break;

		case keys.TAB:
			$("#newAdmin").removeAttr("aria-activedescendant");
			//$('#hint').val('');
			$("#res").remove();
			$('#announce').empty();
			$(".autocomplete-suggestions").hide();
			break;

		case keys.RETURN:
			if (highligted) {
				event.preventDefault();
				event.stopPropagation();
				return selectOption(highligted)
			}

		case keys.UP:
			event.preventDefault();
			event.stopPropagation();
			return moveUp(highligted);
			break;

		case keys.DOWN:
			event.preventDefault();
			event.stopPropagation();

			return moveDown(highligted);
			break;

		default:
			return;
	}
}

function moveUp(highligted) {
	var current;
	$("#newAdmin").removeAttr("aria-activedescendant");
	//$('#hint').val('');
	if (highligted) {
		console.log("Highlighted - " + highligted + "");
		current = $('.highligt');
		current.attr('aria-selected', false);
		current.removeClass('highligt').prev('div').addClass('highligt');
		current.prev('div').attr('aria-selected', true);
		$("#newAdmin").attr("aria-activedescendant", current.prev('div').attr('id'));
		//$('#hint').val($('.highligt').text());
		highligted = false;
	} else {

		//Go back to the bottom of the list

		current = $("#res").children().last('div');
		current.addClass('highligt');
		current.attr('aria-selected', true);
		$("#newAdmin").attr("aria-activedescendant", current.attr('id'));
		//$('#hint').val($('.highligt').text());
	}
}

function moveDown(highligted) {
	var current;
	$("#newAdmin").removeAttr("aria-activedescendant");
	//$('#hint').val('');
	if (highligted) {
		console.log("Highlighted - " + highligted + "");
		current = $('.highligt');
		current.attr('aria-selected', false);
		current.removeClass('highligt').next('div').addClass('highligt');
		current.next('div').attr('aria-selected', true);
		$("#newAdmin").attr("aria-activedescendant", current.next('div').attr('id'));
		//$('#hint').val($('.highligt').text());
		highligted = false;
	} else {

		//Go back to the top of the list
		current = $("#res").children().first('div');
		current.addClass('highligt');
		current.attr('aria-selected', true);
		$("#newAdmin").attr("aria-activedescendant", current.attr('id'));
		//$('#hint').val($('.highligt').text());
	}
}

function selectOption(highligted) {
	if (highligted) {
		$("#newAdmin").removeAttr("aria-activedescendant");
		//$('#hint').val('');
		$('#newAdmin').val($('.highligt').text());
		$('#newAdmin').focus();
		$("#res").remove();
		$('#announce').empty();
		$(".autocomplete-suggestions").hide();
	} else {
		return;
	}
}
