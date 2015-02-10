/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: HU
 */
jQuery.extend(jQuery.validator.messages, {
	required: "Kötelező kitölteni!",
	maxlength: jQuery.validator.format("Legfeljebb {0} karakter hosszú szöveget adjon meg."),
	minlength: jQuery.validator.format("Legalább {0} karakter hosszú szöveget adjon meg."),
	rangelength: jQuery.validator.format("Legalább {0} és legfeljebb {1} karakter hosszú szöveget adjon meg."),
	email: "Érvényes e-mail címet adjon meg.",
	url: "Érvényes URL-t adjon meg.",
	date: "Dátumot adjon meg.",
    datetime: "Dátumot és órát és percet adjon meg.",
    dategreaterthan: "A vég dátumnak nagyobbnak kell lennie.",
	number: "Számot adjon meg.",
	digits: "Csak számjegyek lehetnek.",
	equalTo: "Meg kell egyeznie a két értéknek.",
	range: jQuery.validator.format("{0} és {1} közé kell esnie."),
	max: jQuery.validator.format("Nem lehet nagyobb, mint {0}."),
	min: jQuery.validator.format("Nem lehet kisebb, mint {0}."),
	creditcard: "Érvényes hitelkártyaszámnak kell lennie.",
    accept:"Csak képet adhat meg (png, jpg, jpeg, gif)"
});
