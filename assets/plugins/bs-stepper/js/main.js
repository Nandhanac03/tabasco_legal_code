// Declare variables for steppers
let stepper1, stepper2, stepper3, stepperForm;

document.addEventListener('DOMContentLoaded', function () {
  // Initialize stepper1 if element exists
  const stepper1El = document.querySelector('#stepper1');
  if (stepper1El) {
    stepper1 = new Stepper(stepper1El);
  }

  // Initialize stepper2 with linear: false if element exists
  const stepper2El = document.querySelector('#stepper2');
  if (stepper2El) {
    stepper2 = new Stepper(stepper2El, { linear: false });
  }

  // Initialize stepper3 if element exists
  const stepper3El = document.querySelector('#stepper3');
  if (stepper3El) {
    stepper3 = new Stepper(stepper3El);
  }

  // Initialize stepperForm with animation if element exists
  const stepperFormEl = document.querySelector('#stepperForm');
  if (!stepperFormEl) return; // Exit if no stepperForm element found

  stepperForm = new Stepper(stepperFormEl, { animation: true });

  // Cache selectors for buttons and form inputs
  const btnNextList = Array.from(document.querySelectorAll('.btn-next-form'));
  const stepperPaneList = Array.from(stepperFormEl.querySelectorAll('.bs-stepper-pane'));
  const inputMailForm = document.getElementById('inputMailForm');
  const inputPasswordForm = document.getElementById('inputPasswordForm');
  const form = stepperFormEl.querySelector('.bs-stepper-content form');

  // Attach click event to next buttons to move to next step
  btnNextList.forEach(btn => {
    btn.addEventListener('click', () => {
      stepperForm.next();
    });
  });

  // Validate input fields on step change
  stepperFormEl.addEventListener('show.bs-stepper', event => {
    form.classList.remove('was-validated');

    let nextStep = event.detail.indexStep;
    let currentStep = nextStep > 0 ? nextStep - 1 : 0;

    const stepperPane = stepperPaneList[currentStep];

    // Check inputs based on current pane's ID
    if ((stepperPane.getAttribute('id') === 'test-form-1' && !inputMailForm.value.trim()) ||
        (stepperPane.getAttribute('id') === 'test-form-2' && !inputPasswordForm.value.trim())) {
      event.preventDefault();
      form.classList.add('was-validated');
    }
  });
});
