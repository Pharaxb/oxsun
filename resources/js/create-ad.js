// --- File Upload Logic ---
const file = document.getElementById('file');
const fileNameDisplay = document.getElementById('fileName');
if (file) {
    file.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = '';
        }
    });
}

// --- Age Range Slider Logic ---
const minAgeSlider = document.getElementById('min_age');
const maxAgeSlider = document.getElementById('max_age');
const minAgeLabel = document.querySelector('#min_age_label span');
const maxAgeLabel = document.querySelector('#max_age_label span');

if (minAgeSlider && maxAgeSlider) {
    // Function to update label
    const updateLabels = () => {
        minAgeLabel.textContent = minAgeSlider.value;
        maxAgeLabel.textContent = maxAgeSlider.value;
    };

    // Event listeners
    minAgeSlider.addEventListener('input', () => {
        // Ensure min value is not greater than max value
        if (parseInt(minAgeSlider.value) > parseInt(maxAgeSlider.value)) {
            maxAgeSlider.value = minAgeSlider.value;
        }
        updateLabels();
    });

    maxAgeSlider.addEventListener('input', () => {
        // Ensure max value is not less than min value
        if (parseInt(maxAgeSlider.value) < parseInt(minAgeSlider.value)) {
            minAgeSlider.value = maxAgeSlider.value;
        }
        updateLabels();
    });

    // Initial update
    updateLabels();
}
