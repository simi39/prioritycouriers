<script type="text/javascript">
var dat = $("#dateArr").val();
var dateTest = dat.split(",");
var dateArr = [];
for(var i=0;i<dateTest.length;i++)
{
	dateArr[i] = dateTest[i];
}
var d = $("#defaultDate").val();
var defaultDateset = d;
var m = $("#minDate").val();
var minDate = m;
if(trim(defaultDateset) == "")
{	
	defaultDateset = moment().format();
}
if(trim(minDate) == "")
{
	minDate = moment().format();
}
$('#datetimepicker1').datetimepicker({
	date: defaultDateset,
	minDate: minDate,
	showClose: true,
	ignoreReadonly:true,
	format: 'DD MMM YYYY h:mm a',
	locale: 'en',
	daysOfWeekDisabled: [0,6],
	sideBySide: true,
	widgetPositioning: {
		horizontal: 'left'
	},
	disabledDates:dateArr
});
</script>