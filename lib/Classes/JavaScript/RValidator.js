

var RForm = function(Id)
{
	this.Id				= Id;
	this.Status			= 0;
	this.Validators		= [];
	this.Summaries		= [];
	this.TargetNames	= [];
	this.TargetObjects	= [];
};

RForm.prototype =
{
	AddTarget:function(Id)
	{
		this.TargetNames.push(Id);
	},
	GetObject:function()
	{
		return GetControl(this.Id);
	},
	Find:function(Ctl)
	{
		var Frm = this.GetObject();
		
		if (Frm == null) {
			return;
		}
		
		return Frm.getElementById(Ctl);
	},
	LoadValidation:function(SubmitFunction)
	{
		if (this.Status > 0) {
			return;
		}

		var Object = this.GetObject();
		if (!IsObject(Object)) {
			return;
		}

		REvent.Add(Object, "submit", SubmitFunction);

		Len = this.TargetNames.length;
		for (i = 0; i < Len; i++) {
			this.ProcessTarget(this.TargetNames[i]);
		}
		this.Status = 1;
	},
	ProcessTarget:function(Id)
	{
		var Object = GetControl(Id);
		if (IsObject(Object)) {
			REvent.Add(Object, "click", function() {RxCore.Validation.ActiveTarget = Object;});
		}
	}

};

RForm.Control = { 
	GetValue: function(ControlIn) {
		
		var Control;
		
		if (IsControl(ControlIn)) { 
			Control = ControlIn;	
		}
		else {
			
			Control = GetControl(ControlIn);
			if (!IsControl(Control)) {
				return null;
			}
		}

		var TagName = Control.tagName.toLowerCase();
		if (IsFunction(RForm.Control.MapValue[TagName])) {
			return RForm.Control.MapValue[TagName](Control);
		}
		return null;
	}
};

RForm.Control.MapValue = {
	input:function(Control)
	{
		switch(Control.type.toLowerCase())
		{
			case 'checkbox':
			case 'radio':
				if (!Control.checked) {
					return null;
				}
				break;
		};
		
		return Control.value;
	}
};

RxCore.Validation = function()
{
};

RxCore.Validation.RForms		= [];
RxCore.Validation.Status		= 0;
RxCore.Validation.ActiveTarget	= null;
RxCore.Validation.Summaries		= [];

// get RForm object from collection
RxCore.Validation.GetRForm = function(Id)
{
	var i;
	for (i = 0; i < RxCore.Validation.RForms.length; i++) {
		if (RxCore.Validation.RForms[i].Id ==Id) {
			return RxCore.Validation.RForms[i];
		}
	}
	return null;
};

// add form in collection through id
RxCore.Validation.AddForm = function(Id)
{	
	if (RxCore.Validation.GetRForm(Id))	{
		return;
	}
	var Frm = new RForm(Id);
	RxCore.Validation.RForms.push(Frm);
};

// add target for given form id
RxCore.Validation.AddTarget = function(FrmId, TargetId)
{
	var Frm = RxCore.Validation.GetRForm(FrmId);
	if (Frm) {
		Frm.AddTarget(TargetId);
	}
}


RxCore.Validation.Add = function(FrmId, Validator, Attr)
{ 
	var Frm = RxCore.Validation.GetRForm(FrmId);
	if (!Frm) { 
		return;
	}
	if (!IsObject(Attr))	{
		return;
	} 
	Frm.Validators.push(new RxCore.Validator(Validator, Attr));
}


// onload event handler
RxCore.Validation.OnLoad = function()
{
	RxCore.Validation.Status = 1;

	var i;
	var Len;

	Len = RxCore.Validation.RForms.length;
	for (i = 0; i < Len; i++) {
		RxCore.Validation.RForms[i].LoadValidation(RxCore.Validation.OnSubmit);
	}
};

// OnSubmit handler
RxCore.Validation.OnSubmit = function(Evt)
{
	if (!RxCore.Validation.ActiveTarget) {
		return true;
	}

	// Event source
	var Source		= REvent.Source(Evt);
	var bStopEvent	= true;

	if (Source == null && IsControl(Evt)) {
		Source		= Evt;
		bStopEvent	= false;
	}
	
	
	
	var Frm = RxCore.Validation.GetRForm(Source.id || Source.name);
	if (Frm == null) {
		return true;
	}
	
	var IsValid = RxCore.Validation.IsValid(Frm);

	if (Source && !IsValid && bStopEvent) {
		REvent.Stop(Evt);
	}

	RxCore.Validation.ActiveTarget = null;
	return IsValid;
};

RxCore.Validation.IsValid = function(Frm)
{
	if (!Frm){
		return true;
	}
	var		Valid		= true;
	var		Validators	= Frm.Validators;
	var		i;
	var		s;
	
	for (i = 0; i < Validators.length; i++) {
		Valid = Valid & Validators[i].Validate();
	}
	
	var		Summaries	= Frm.Summaries;
	for (s = 0; s < Summaries.length; s++) {
		Summaries[s].Show(Frm);
	}
	//RxCore.Validation.ShowSummary(Frm);
	return Valid;
}


/**
 * Validation summary function.
*/
RxCore.Validation.AddSummary = function(FrmId, Attr)
{		
	var Frm = RxCore.Validation.GetRForm(FrmId);
	if (!Frm) { 
		return;
	}
	if (!IsObject(Attr))	{
		return;
	} 
	Frm.Summaries.push(new RxCore.Validation.RValidationSummary(Attr));
}
/**
 * Show the validation error message summary.
 * @param {element} the form that activated the summary call.
*/
RxCore.Validation.RValidationSummary = function(Attr)
{
	this.Attr		= Attr;
	this.Enabled	= IsBoolean(Attr.Enabled) ? Attr.Enabled : true;
	this.Visible	= IsBoolean(Attr.Visible) ? Attr.Visible : true;
};

RxCore.Validation.RValidationSummary.prototype = { 
	/**
	 * Return the format parameters for the summary.
	 * @param {string} format type, "List", "SingleParagraph" or "BulletList"
	 * @type {array} formatting parameters
	 */
	FormatMessageBox : function(Messages,HeaderText)
	{ 
		var Output = '';
		if(HeaderText && Messages.length > 0) { 
			Output += HeaderText + "\n";                                             
		}
		for(var i = 0; i < Messages.length; i++) {  
			switch(this.Attr.DisplayMode) {
				case "list":
					Output += Messages[i] + "\n";
					break;
				case "bulletbist":
					Output += " - " + Messages[i] + "\n";
					break;
				case "singleparagraph":
					Output += Messages[i] + " ";
					break;
				default:
					Output += " - " + Messages[i] + "\n";
					break;
			}
		}
		return Output;
	},
	Show:function(Frm)
	{ 	
		if (!Frm) {
			return true;
		}
		var		Valid		= true;
		var		Validators	= Frm.Validators;
		var		i;
		var Messages = [];
		for(var i = 0; i < Validators.length; i++) {  
			var IsValid = Validators[i].Validate();
			if(!IsValid) {
				Messages.push(Validators[i].Attr.ErrorMessage); 
			}
		}
		if(this.Attr.ShowSummary && Messages.length > 0) {
			alert(this.FormatMessageBox(Messages,this.Attr.HeaderText));
		}
	}
}

/** 
 * Convert a string into integer, returns null if not integer.
 * @param {string} the string to convert to integer
 * @type {integer|null} null if string does not represent an integer.
 */
RxCore.Validation.ToInteger = function(Value)
{ 	
	var exp = /^\s*[-\+]?\d+\s*$/;
	if (Value.match(exp) == null) { 
		return null;
	}
	var num = parseInt(Value, 10);
	if(num) {
		return (isNaN(num) ? null : num);
	} 
}
/** 
 * Convert a string into a double/float value. <b>Internationalization 
 * is not supported</b>
 * @param {string} the string to convert to double/float
 * @param {string} the decimal character
 * @return {float|null} null if string does not represent a float value
 */
RxCore.Validation.ToDouble = function(value,decimalchar)
{ 	
	if(IsUndefined(decimalchar)) { 
		var decimalchar = decimalchar;
	} else {
		var decimalchar = ".";
	}
	var exp = new RegExp("^\\s*([-\\+])?(\\d+)?(\\" + decimalchar + "(\\d+))?\\s*$");
    var m = value.match(exp);
    if (m == null)	
		return null;
	var cleanInput = m[1] + (m[2].length>0 ? m[2] : "0") + "." + m[4];
    var num = parseFloat(cleanInput);
    return (isNaN(num) ? null : num);
}

RxCore.Validation.IsDate = function(value, format)
{ 
	var ro = value.split(/\W+/);
	if( ro==null ) {
		return null;
	}
	var d, m, y;
	if(format=="dd/mm/yyyy") {
		d = ro[0];
		m = ro[1];
		y = ro[2];
	}
	else if(format=="mm/dd/yyyy") {
		d = ro[1];
		m = ro[0];
		y = ro[2];
	}
	else if(format=="mm-dd-yyyy") {
		d = ro[1];
		m = ro[0];
		y = ro[2];
	}
	else {
		return null;
	}
	m = m - 1;
	var date = new Date(y,m,d);
	if( typeof(date)!='object' || date.getFullYear()!=y || date.getMonth()!=m || date.getDate()!=d ) {
		return null;
	}
	return date;
}
REvent.OnLoad(RxCore.Validation.OnLoad);

/**
 * Convert strings that represent a currency value (e.g. a float with grouping 
 * characters) to float. E.g. "10,000.50" will become "10000.50". The number 
 * of dicimal digits, grouping and decimal characters can be specified.
 * <i>The currency input format is <b>very</b> strict, null will be returned if
 * the pattern does not match</i>.
 * @param {string} the currency value
 * @param {string} the grouping character, default is ","
 * @param {int} number of decimal digits
 * @param {string} the decimal character, default is "."
 * @type {float|null} the currency value as float.
 */
RxCore.Validation.ToCurrency = function(value, groupchar, digits, decimalchar)
{  
	groupchar = groupchar ? "," : groupchar;
	decimalchar = decimalchar ? "." : decimalchar;
	digits = digits ? 2 : digits;

	var exp = new RegExp("^\\s*([-\\+])?(((\\d+)\\" + groupchar + ")*)(\\d+)"
		+ ((digits > 0) ? "(\\" + decimalchar + "(\\d{1," + digits + "}))?" : "")
        + "\\s*$");
	var m = value.match(exp);
	if (m == null)
		return null;
	var intermed = m[2] + m[5] ;
    var cleanInput = m[1] + intermed.replace(
			new RegExp("(\\" + groupchar + ")", "g"), "") 
							+ ((digits > 0) ? "." + m[7] : "");
	var num = parseFloat(cleanInput);
	return (isNaN(num) ? null : num);
}

RxCore.Validator = function(Validator, Attr)
{
	this.EvalFunc	= Validator;
	this.IsValid	= true;
	this.Attr		= Attr;
	this.Enabled	= IsBoolean(Attr.Enabled) ? Attr.Enabled : true;
	this.Visible	= IsBoolean(Attr.Visible) ? Attr.Visible : true;
};

RxCore.Validator.prototype = {   
	Validate:function()
	{   
		if (!this.Enabled)	{
			return true;
		}
		if (!this.Visible) {
			return true;
		}
		if (!this.EvalFunc)	{
			return true;
		}
		this.Control = GetControl(this.Attr.ControlToValidate);
		if (!this.Control) {
			return true;
		}
		/*
		* Code for check validation condition.
		*/
		if(!IsUndefined(this.Attr.ValidationField) && !IsUndefined(this.Attr.ValidationCondition)) {      
			this.NotEmptyControl = GetControl(this.Attr.ValidationField);
			var Value =	RForm.Control.GetValue(this.NotEmptyControl);
			switch(this.Attr.ValidationCondition)
			{
				case 'NotEmpty':
					if(!Trim(Value)) { 
						return false;	
						break;
					}
				case 'ValueEqualTo':
					if(Value != this.Attr.ValidationCompareValue) {
						return false;	
					}
					break;
			}
		}
		/*
		* End of code for check validation condition.
		*/
		this.IsValid = this.EvalFunc();
		this.Update();
		return this.IsValid;
	},
	Update:function()
	{	
		var ValControl = GetControl(this.Attr.Id);
		if (!ValControl)	{
			return;
		}

		if (this.Attr.Display == "dynamic") {
			RControl.Display(ValControl, !this.IsValid);
		}
		
		RControl.Visible(ValControl, !this.IsValid);
	}
};

RxCore.Validator.RRequiredFieldValidator = function()
{ 	
	var Value =	RForm.Control.GetValue(this.Control);
	return Trim(Value) != Trim(this.InitialValue);
};

RxCore.Validator.RCompareValidator = function()
{	
	var Value = RForm.Control.GetValue(this.Control);
	if (Value.length == 0) {
		return true;
	}
	var CompareTo;
	var Comparee = GetControl(this.Attr.Controlhookup);
	if(Comparee){ 
		CompareTo = Trim(RForm.Control.GetValue(Comparee));
	}
	else
	{
		CompareTo = IsString(this.Attr.ValueToCompare) ? this.Attr.ValueToCompare : "";
	}
	this.Compare = RxCore.Validator.RCompareValidator.Compare;
	var IsValid =  this.Compare(Value, CompareTo);
	return IsValid;
}

RxCore.Validator.RCompareValidator.Convert = function(DataType, Value)
{ 
	switch(DataType) {
		case "integer":return RxCore.Validation.ToInteger(Value);
		case "double":return RxCore.Validation.ToDouble(Value,this.Attr.DecimalChar);
		case "float":return RxCore.Validation.ToDouble(Value,this.Attr.DecimalChar);
		case "currency":return RxCore.Validation.ToCurrency(Value,this.Attr.GroupChar,this.Attr.Digits,this.Attr.DecimalChar);
		case "date":return RxCore.Validation.IsDate(Value,this.Attr.DateFormat);
	}
}
RxCore.Validator.RTypeValidator = function()
{
	var Value = RForm.Control.GetValue(this.Control);
	if (Value.length == 0) {
		return true;
	}
	this.Convert = RxCore.Validator.RCompareValidator.Convert;
	if ((NewValue = this.Convert(this.Attr.Type, Value)) == null) { 
		return false;
	}
	else {
		return true;	
	}
}
RxCore.Validator.RCompareValidator.Compare = function(operand1, operand2)
{ 	
	var Op1,Op2,operand1,operand2;
	this.Convert = RxCore.Validator.RCompareValidator.Convert;
	if ((Op1 = this.Convert(this.Attr.Type, operand1)) == null) { 
		return false;
	}
	if (this.Attr.Operator == "DataTypeCheck") {
        return true;
	}
	if ((Op2 = this.Convert(this.Attr.Type,operand2)) == null) { 
        return false;
	}
	
    switch (this.Attr.Operator) 
	{
        case "notequal":
            return (Op1 != Op2);
        case "greaterthan":
            return (Op1 > Op2);
        case "greaterthanequal":
            return (Op1 >= Op2);
        case "lessthan":
            return (Op1 < Op2);
        case "lessthanequal":
            return (Op1 <= Op2);
        default:
            return (Op1 == Op2);
    }
}

RxCore.Validator.RRegularExpressionValidator = function()
{
	var Value = Trim(RForm.Control.GetValue(this.Control));
    if (Value == "") return true;
    var Rx = new RegExp(this.Attr.Validationexpression);
    var Matches = Rx.exec(Value);
    return (Matches != null && Value == Matches[0]);
}

RxCore.Validator.RRangeValidator = function()
{	
	var Value = Trim(RForm.Control.GetValue(this.Control));
	var DataType = this.Attr.Type;
    if (Value == "") return true;

    var Minval = this.Attr.MinValue;
    var Maxval = this.Attr.MaxValue;

    if (Minval == "") Minval = 0;
	if (Maxval == "") Maxval = 0;

	//now do datatype range check.
	this.Convert = RxCore.Validator.RCompareValidator.Convert;
	Value = this.Convert(DataType, Value);
	if(Value==null)
	{	return false;	}
	else
	{
		if(Minval) {	
			var min = this.Convert(DataType, Minval);
			if(min==null){	return false;	}
		}
		if(Maxval)	{
			var max = this.Convert(DataType, Maxval);
			if(max==null){	return false;	}
		}
		if(Minval || Maxval)
		{	return Value >= min && Value <= max;	}
		else if(!Minval || !Maxval)
		{	return true;	}
	}
}
//RxCore.Validator.REmailAddressValidator = RxCore.Validator.RRegularExpressionValidator;
// For TMS Site
function Required(FormId,Field,Msg) {  
	var Value =	eval("document."+FormId+"."+Field+".value");
	if(!Value) {
		alert(Msg);
		eval("document."+FormId+"."+Field+".focus()");
		return false;
	} 
}

function IsInteger(FormId,Field,Msg) { 	
	var exp = /^\s*[-\+]?\d+\s*$/;
	var Value =	eval("document."+FormId+"."+Field+".value");
	if (Value.match(exp) == null) { 
		return false;
	}
	var num = parseInt(Value, 10);
	if(num) { 
		if(isNaN(num)) { 
			return false;
		} 
	} 
	else {
		return false;
	}
}

function RangeValidator(FormId,Field,Msg)
{	
	
	//alert(Field);
	Field1 = new String(Field);
	splitString = Field1.split(",");
	var FieldName = splitString[4]; //Field Name
	var Value =	eval("document."+FormId+"."+FieldName+".value");
		
	var DataType = splitString[3];//DataType
    if (Value == "") return true;
    var Minval = splitString[1];//Minimum Value
    var Maxval = splitString[2];//Maximum Value

    if (Minval == "") Minval = 0;
	if (Maxval == "") Maxval = 0;
	if(Value==null)
	{	return false;	}
	else
	{
		if(Minval) {
			var min = this.funConvert(DataType, Minval);
			if(min==null){return false;	}
		}
		if(Maxval)	{
			var max = this.funConvert(DataType, Maxval);
			if(max==null){ return false;	}
		}
		if(Value > max){alert(Msg);}
		if(Value < min){alert(Msg);}
		
		if(Minval || Maxval)
		{ return Value >= min && Value <= max;	}
		else if(!Minval || !Maxval)
		{  return true;	}
		
	}
		
}

function funConvert(DataType, Value)
{ 
	switch(DataType)
	{
		case "integer":return funToInteger(Value);
		/*case "double":return RxCore.Validation.ToDouble(Value,this.Attr.DecimalChar);
		case "float":return RxCore.Validation.ToDouble(Value,this.Attr.DecimalChar);
		case "currency":return RxCore.Validation.ToCurrency(Value,this.Attr.GroupChar,this.Attr.Digits,this.Attr.DecimalChar);
		case "date":return RxCore.Validation.IsDate(Value,this.Attr.DateFormat);*/
	}
}
function ToDouble(value,decimalchar)
{ 	
	if(IsUndefined(decimalchar)) { 
		var decimalchar = decimalchar;
	} else {
		var decimalchar = ".";
	}
	var exp = new RegExp("^\\s*([-\\+])?(\\d+)?(\\" + decimalchar + "(\\d+))?\\s*$");
    var m = value.match(exp);
    if (m == null)	
		return null;
	var cleanInput = m[1] + (m[2].length>0 ? m[2] : "0") + "." + m[4];
    var num = parseFloat(cleanInput);
    return (isNaN(num) ? null : num);
}

function IsDate(value, format)
{ 
	var ro = value.split(/\W+/);
	if( ro==null ) {
		return null;
	}
	var d, m, y;
	if(format=="dd/mm/yyyy") {
		d = ro[0];
		m = ro[1];
		y = ro[2];
	}
	else if(format=="mm/dd/yyyy") {
		d = ro[1];
		m = ro[0];
		y = ro[2];
	}
	else if(format=="mm-dd-yyyy") {
		d = ro[1];
		m = ro[0];
		y = ro[2];
	}
	else {
		return null;
	}
	m = m - 1;
	var date = new Date(y,m,d);
	if( typeof(date)!='object' || date.getFullYear()!=y || date.getMonth()!=m || date.getDate()!=d ) {
		return null;
	}
	return date;
}

function ToCurrency(value, groupchar, digits, decimalchar)
{  
	groupchar = groupchar ? "," : groupchar;
	decimalchar = decimalchar ? "." : decimalchar;
	digits = digits ? 2 : digits;

	var exp = new RegExp("^\\s*([-\\+])?(((\\d+)\\" + groupchar + ")*)(\\d+)"
		+ ((digits > 0) ? "(\\" + decimalchar + "(\\d{1," + digits + "}))?" : "")
        + "\\s*$");
	var m = value.match(exp);
	if (m == null)
		return null;
	var intermed = m[2] + m[5] ;
    var cleanInput = m[1] + intermed.replace(
			new RegExp("(\\" + groupchar + ")", "g"), "") 
							+ ((digits > 0) ? "." + m[7] : "");
	var num = parseFloat(cleanInput);
	return (isNaN(num) ? null : num);
}

function funToInteger(Value)
{ 	
	var exp = /^\s*[-\+]?\d+\s*$/;
	if (Value.match(exp) == null) { 
		return null;
	}
	var num = parseInt(Value, 10);
	if(num) {
		return (isNaN(num) ? null : num);
	} 
}


function RegularExpressionValidator(FormId,Field,Msg)
{
	var Value =	eval("document."+FormId+"."+Field+".value");
	
    if (Value == "") return true;
	var exp = /^\d/;
    var Rx = new RegExp(exp);
	
	
	var Matches = Rx.exec(Value);
	
	if(Matches == null)
	{
		alert(Msg);
	}
	return (Matches != null && Value == Matches[0]);
	
}


function CompareValidator(FormId,Field,Msg)
{
	
	Field1 = new String(Field); 
	splitString = Field1.split(",");
	FieldName2 = splitString[4];//Name Of Field
	var Value =	eval("document."+FormId+"."+FieldName2+".value");
	if (Value.length == 0)
	{
		return true;
	}
	var CompareTo;
	FieldName1 = splitString[5];
	var Comparee =	eval("document."+FormId+"."+FieldName1+".value");
		
	if(Comparee){ 
		CompareTo = eval("document."+FormId+"."+FieldName1+".value");//Trim(RForm.Control.GetValue(Comparee));
	}
	else
	{
		CompareTo = IsString(eval("document."+FormId+"."+FieldName1+".value")) ? eval("document."+FormId+"."+FieldName1+".value") : "";
		
	}
	//this.Compare = this.CompareOperator();
	//var IsValid =  this.Compare(Value, CompareTo,splitString[3],splitString[2], Msg);
	
	var IsValid = this.CompareOperator(Value, CompareTo,splitString[3],splitString[2], Msg);
	if(!IsValid)
	{
		alert(Msg);
		eval("document."+FormId+"."+FieldName2+".focus()");
		return false;
	}
	return IsValid;
}


function CompareOperator(operand1, operand2, DataType, Operator, Msg1)
{ 	
	var Op1,Op2,operand1,operand2,DataType,Operator,Msg1;
	
	this.Convert = this.funConvert();
	if ((Op1 = this.funConvert(DataType, operand1)) == null) { 
		return false;
	}
	if (DataType == "DataTypeCheck") {
        return true;
	}
	if ((Op2 = this.funConvert(DataType,operand2)) == null) { 
        return false;
	}
	
    switch (Operator) 
	{
        case "notequal": 
            return (Op1 != Op2);
        case "greaterthan":
            return (Op1 > Op2);
        case "greaterthanequal":
            return (Op1 >= Op2);
        case "lessthan":
            return (Op1 < Op2);
        case "lessthanequal":
            return (Op1 <= Op2);
        default:
			return (Op1 == Op2);
    }
}
