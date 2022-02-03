$(document).ready(function () {

	var amount1 = document.getElementById("amount1").value;
	var amount2 = document.getElementById("amount2").value;
	
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 600,
        values: [amount1, amount2],
        slide: function (event, ui) {
            $("#amount1").val(ui.values[0]);
            $("#amount2").val(ui.values[1]);
        }
    });

    $("#amount1").val($("#slider-range").slider("values", 0));
    $("#amount2").val($("#slider-range").slider("values", 1));


    $(function () {
        var dateFormat = "mm/dd/yy",
            from = $("#from")
                .datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
            to = $("#to").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1
            })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }
    });
   
});
