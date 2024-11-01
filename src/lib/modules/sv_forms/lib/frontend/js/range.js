document.addEventListener('DOMContentLoaded', function() {
    const ranges = document.querySelectorAll('.wp-block-straightvisions-sv-forms-range input[type="range"]');
    const numbers = document.querySelectorAll('.wp-block-straightvisions-sv-forms-range input[type="number"]');
    
    ranges.forEach(function(range) {
        range.addEventListener('input', function() {
            const number = this.parentNode.parentNode.querySelector('input[type="number"]');
            if (number) {
                number.value = this.value;
            }
        });
    });
    
    numbers.forEach(function(number) {
        number.addEventListener('input', function() {
            const range = this.parentNode.querySelector('input[type="range"]');
            if (range) {
                range.value = this.value;
            }
        });
    });
});
