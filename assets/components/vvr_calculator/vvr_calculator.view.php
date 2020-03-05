<div id="vvr-calculator">
		<fieldset class="group-infusion">
		<legend>Vasoactive Inotrope Score (VIS)</legend>
		<h3>Input the current infusion dosages to determine the VIS</h3>

		<div class="field-wrapper">
			<label>Dopamine dose</label><input type="number" data-bind="INFUSION_DOPAMINE"> <span class="uom">(mcg/kg/min)</span>
		</div>
		<div class="field-wrapper">
			<label>Dobutamine dose</label><input type="number" data-bind="INFUSION_DOBUTAMINE"> <span class="uom">(mcg/kg/min)</span>
		</div>
		<div class="field-wrapper">
			<label>Epinephrine dose</label><input type="number" data-bind="INFUSION_EPINEPHRINE" data-multiplier="100"> <span class="uom">(mcg/kg/min &times; 100)</span> = <span class="calculated-value" data-bind="INFUSION_EPINEPHRINE"></span>
		</div>
		<div class="field-wrapper">
			<label>Milrinone dose</label><input type="number" data-bind="INFUSION_MILRINONE" data-multiplier="10"> <span class="uom">(mcg/kg/min &times; 10)</span> = <span class="calculated-value" data-bind="INFUSION_MILRINONE"></span>
		</div>
		<div class="field-wrapper">
			<label>Vasopressin dose</label><input type="number" data-bind="INFUSION_VASOPRESSIN" data-multiplier="10000"> <span class="uom">(units/kg/min &times; 10,000)</span> = <span class="calculated-value" data-bind="INFUSION_VASOPRESSIN"></span>
		</div>
		<div class="field-wrapper">
			<label>Norepinephrine dose</label><input type="number" data-bind="INFUSION_NOREPINEPHRINE" data-multiplier="100"> <span class="uom">(mcg/kg/min &times; 100)</span> = <span class="calculated-value" data-bind="INFUSION_NOREPINEPHRINE"></span>
		</div>
		<div class="calculated-field-wrapper subtotal">
			<label>VIS Total</label><span class="calculated-value" data-bind="INFUSION_VIS_TOTAL"></span>
		</div>
	</fieldset>

	<fieldset class="group-ventilation">
		<legend>Ventilation Index (VI)</legend>
		<h3>Complete the following fields to determine the Ventilation Index</h3>
		<p>Ventilation Index (VI) = ( RR &times; (PIP-PEEP) &times; PaCO2 ) / 1000 &#8212; it is <em>automatically calculated for you</em></p>
		<div class="field-wrapper">
			<label>Ventilator rate (RR)</label><input type="number" data-bind="VENTILATION_RATE"> <span class="uom">Breaths/minute</span>
		</div>
		<div class="field-wrapper">
			<label>Peak Inspiratory Pressure (PIP)</label><input type="number" data-bind="VENTILATION_PIP"> <span class="uom">cmH<sub>2</sub>O</span>
		</div>
		<div class="field-wrapper">
			<label>Positive End-Expiratory Pressure (PEEP)</label><input type="number" data-bind="VENTILATION_PEEP"> <span class="uom">cmH<sub>2</sub>O</span>
		</div>
		<div class="field-wrapper">
			<label>Arterial PCO2</label><input type="number" data-bind="VENTILATION_APCO2"> <span class="uom">mmHg</span>
		</div>
		<div class="calculated-field-wrapper subtotal">
			<label>Ventilation Index</label><span class="calculated-value" data-bind="VENTILATION_INDEX"></span>
		</div>

	</fieldset>

	<fieldset class="group-creatinine">
		<legend>Ventilation Index (VI)</legend>
		<h3>Complete the following fields to determine ΔCr</h3>
		<p>ΔCr = (Postoperative Creatinine - Preoperative Creatinine) &times; 10 &#8212; it is <em>automatically calculated for you</em></p>
		<p>For postoperative creatinine, use the most recent measurement at time of VVR calculation</p>
		<div class="field-wrapper">
			<label>Preoperative (baseline) Creatinine</label><input type="number" data-bind="CREATININE_PREOP"> <span class="uom">mg/dL</span>
		</div>
		<div class="field-wrapper">
			<label>Postoperative Creatinine</label><input type="number" data-bind="CREATININE_POSTOP"> <span class="uom">mg/dL</span>
		</div>
		<div class="calculated-field-wrapper subtotal">
			<label>ΔCr</label><span class="calculated-value" data-bind="CREATININE_DELTA"></span>
		</div>

	</fieldset>

	<div class="calculated-field-wrapper clearfix" id="vvr-score">
		<label>Vasoactive Ventilation Renal Score (VVR)</label><span class="calculated-value" data-bind="VVR_SCORE"></span>
		<p><a class="button btn-reset">RESET/CLEAR FIELDS</a></p>
	</div>

</div>
