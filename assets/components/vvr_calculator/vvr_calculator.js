/**
 * Interactive Vasoactive Ventilation Renal Score (VVR) Calculator Widget
 * Calculates VVR from data input on form fields
 */
(function($){
	"use strict";
	$(function(){

		var b = {
			el: $('#vvr-calculator'), // Reference to widget container element
		};

		// Abort processing if widget not found on page
		if (b.el.length === 0) {
			return false;
		}

		// Set up internal calculator variables
		b.vars = {

			// Dosage Information
			INFUSION_DOPAMINE:          0, // mcg/kg/min
			INFUSION_DOBUTAMINE:        0, // mcg/kg/min
			INFUSION_EPINEPHRINE:       0, // mcg/kg/min x 100
			INFUSION_MILRINONE:         0, // mcg/kg/min x 10
			INFUSION_VASOPRESSIN:       0, // units/kg/min x 10,000
			INFUSION_NOREPINEPHRINE:    0, // mcg/kg/min x 100
			INFUSION_VIS_TOTAL:         0, // Vasoactive Inotrope Score (Calculated)

			// Ventilation Information
			VENTILATION_RATE:           0, // Breaths/minute
			VENTILATION_PIP:            0, // Peak Inspiratory Pressure (cmH2O)
			VENTILATION_PEEP:           0, // Positive End Expiratory Pressure (cmH2O)
			VENTILATION_APCO2:          0, // Arterial PCO2 (mmHg)
			VENTILATION_INDEX:          0, // Ventilation Index (Calculated)

			// Creatinine Information
			CREATININE_PREOP:           0, // Preoperative (baseline) Creatinine (mg/dL)
			CREATININE_POSTOP:          0, // Postoperative Creatinine (mg/dL)
			CREATININE_DELTA:           0, // Calculated Score

			VVR_SCORE:                  0 // Calculated VVR Score

		};

		b.calc = function() {

			// Calculate VIS
			b.vars.INFUSION_VIS_TOTAL = b.vars.INFUSION_DOPAMINE;
			b.vars.INFUSION_VIS_TOTAL += b.vars.INFUSION_DOBUTAMINE;
			b.vars.INFUSION_VIS_TOTAL += b.vars.INFUSION_EPINEPHRINE;
			b.vars.INFUSION_VIS_TOTAL += b.vars.INFUSION_MILRINONE;
			b.vars.INFUSION_VIS_TOTAL += b.vars.INFUSION_VASOPRESSIN;
			b.vars.VVR_SCORE = b.vars.INFUSION_VIS_TOTAL += b.vars.INFUSION_NOREPINEPHRINE;

			// Calculate VI
			b.vars.VVR_SCORE += b.vars.VENTILATION_INDEX = (b.vars.VENTILATION_RATE * (b.vars.VENTILATION_PIP - b.vars.VENTILATION_PEEP) * b.vars.VENTILATION_APCO2) / 1000;

			// Calculate delta Cr
			var DCR = (b.vars.CREATININE_POSTOP - b.vars.CREATININE_PREOP) * 10;
			b.vars.VVR_SCORE += b.vars.CREATININE_DELTA = (DCR <= 0) ? 0 : DCR;

			b.refreshUI();

		};

		// Handle changes to form inputs
		b.onInput = function(e) {
			var field = $(this);
			var multi = Number(field.data('multiplier') || 1);
			b.vars[field.data('bind')] = Number(field.val()) * multi;
			b.calc();
		};

		// Update any bound values with changed data
		b.refreshUI = function() {
			b.el.find('.calculated-value').each(function(){
				var target = $(this);
				target.html((b.vars[target.data('bind')]).toFixed(1));
			});
		};

		// Clear the form
		b.reset = function() {
			$.each(b.vars, function(index, v){
				b.vars[index] = 0;
			});
			b.el.find('[data-bind]').each(function(){
				var target = $(this);
				if (target.is('input')) {
					target.val('');
				} else {
					target.empty();
				}
			});
			b.calc();
		};

		// Set initial state
		b.reset();

		// Bind event handlers
		b.el.on('change', 'input[data-bind]', b.onInput);
		b.el.on('click', '.btn-reset', b.reset);

		window.VVRCalculator = b;

	});
})(jQuery);
