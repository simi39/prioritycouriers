
if (!Array.prototype.push)
{
	Array.prototype.push = function()
	{
		var StartLength = this.length;

		for (var i = 0; i < arguments.length; i++) {
			this[StartLength + i] = arguments[i];
		}
		return this.length;
	} // push
};

if (!Function.prototype.apply)
{
	Function.prototype.apply = function(object, parameters)
	{
		var ParameterStrings = new Array();

		if (!object) {
			object = window;
		}

		if (!parameters) {
			parameters = new Array();
		}

		for (var i = 0; i < parameters.length; i++) {
			ParameterStrings[i] = 'parameters[' + i + ']';
		}

		object.__apply__ = this;
		var result = eval('object.__apply__(' + ParameterStrings.join(', ') + ')');
		object.__apply__ = null;
		return result;
	}
};


function IsBoolean(a)
{
	return typeof a == 'boolean'
}

function IsFunction(a)
{
	return typeof a == 'function'
}

function IsNull(a)
{
	return typeof a == 'object' && !a
}

function IsString(a)
{
	return typeof a == 'string'
}

function IsUndefined(a)
{
	return typeof a == 'undefined'
}

function IsFinite(a)
{
	return isFinite(a);
}

function IsNumber(a)
{
	return typeof a == 'number' && IsFinite(a)
}

function IsObject(a)
{
	return (a && typeof a == 'object') || IsFunction(a)
}

function IsRegexp(a)
{
	return a && a.constructor == RegExp
}

function IsArray(a)
{
	return IsObject(a) && a.constructor == Array
}

function IsControl(o, strict)
{
	return o && IsObject(o) && ((! strict && (o == window || o == document)) || o.nodeType == 1)
}

function Trim(Value)
{
	if (IsUndefined(Value)) {
		return "";
	}

	return Value.replace(/^\s+|\s+$/g, "");
};

function GetControl(n, d)
{
	if (IsControl(n)) {
		return n;
	}

	if (IsString(n) == false) {
		return null;
	}

	var p, i, x;

	if (!d) {
		d = document;
	}

/*	if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
		d = parent.frames[n.substring(p + 1)].document;
		n = n.substring(0, p);
	}
*/
	if (!(x = d[n]) && d.all) {
		x = d.all[n];
	}

	for (i = 0; !x && i < d.forms.length; i++) {
		x = d.forms[i][n];
	}

	if (typeof(DOM) != 'undefined') {
		for (i = 0; !x && d.layers && i < d.layers.length; i++) {
			x = DOM.find(n, d.layers[i].document);
		}
	}

	if (!x && d.getElementById) {
		x = d.getElementById(n);
	}

//	alert(n);
//	alert(d.all[n]);
//	alert(d.forms[i][n]);
//	alert(d.getElementById(n));
	

	return x;
}


var RControl = 
{
	Display:function(Ctl, Show)
	{
		if (Show) {
			Ctl.style.display = '';
		}
		else {
			Ctl.style.display = 'none';
		}
	},
	Visible:function(Ctl, Show)
	{ 
		if (Show) {
			Ctl.style.visibility = 'visible';
		}
		else {
			Ctl.style.visibility = 'hidden';
		}
	},
	Clear:function(Ctl)
	{
		Ctl.Value = '';
	},
	Focus:function(Ctl) {
    	Ctl.focus();
  	}

};



var REvent = {
	// _add_event
	_add_event:function(target, event_name, fnc)
	{
		if (target == null) {
			// add event to body object
			target = document.addEventListener && ! window.addEventListener ? document : window;
		}

		// add handler
		if (target.addEventListener) {
			target.addEventListener(event_name, fnc, false);
		}
		else if (target.attachEvent) {
			target.attachEvent('on' + event_name, fnc);
		}
		
	},
	Add:function(Target, EventName, Fnc)
	{
		if (IsArray(Target)) {
			for (var i = 0; i < Target.length; i++) {
				this._add_event(Target[i], EventName, Fnc);
			}
		}
		else {
			this._add_event(Target, EventName, Fnc);
		}
	},
	Event:function(EventParam)
	{
		if (EventParam) {
			return EventParam;
		}
		else if(window.event) {
			return event;
		}
		else if(window.Event) {
			return Event;
		}
		return null;
	},
	Stop:function(EventParam)
	{
		EventParam = REvent.Event(EventParam);
		if (EventParam.preventDefault)	{
			EventParam.preventDefault();
			EventParam.stopPropagation();
		}
		else {
			EventParam.returnValue = false;
		}
	},
	// on Load
	OnLoad:function(fnc)
	{
		REvent.Add(null, 'load', fnc);
	},
	Source:function(Evt)
	{
		Evt = REvent.Event(Evt);
		return Evt.target || Evt.srcElement;
	}
};


var RxCore = 
{
	Version:1.0
};

