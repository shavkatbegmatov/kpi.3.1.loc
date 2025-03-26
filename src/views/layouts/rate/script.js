const rateStage = document.querySelector('#rate');
const advantagesStage = document.querySelector('#advantages');
const disadvantagesStage = document.querySelector('#disadvantages');
const submit = document.querySelector('#submit');

advantagesStage.style.display = 'none';
disadvantagesStage.style.display = 'none';
submit.style.display = 'none';

function rate(rate) {
    rateStage.style.display = 'none';
    if (rate == 5) {
        advantagesStage.style.display = 'block';
    } else {
        disadvantagesStage.style.display = 'block';
    }
    submit.style.display = 'block';
}