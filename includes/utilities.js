var invalid_characters = ["-", "+", "e"];
// Doesn't work :((
var prevent_unexpected_characters = function(event) {
	// (on)keydown
	if (invalid_characters.includes(event.which)) {
		event.preventDefault();
	}
	// (on)input -> dont need to use the event parameter.
	// this.value = this.value.replace(/[e\+\-]/gi, "");
}
