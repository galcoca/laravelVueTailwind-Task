# laravelVueTailwind-Task
Gabriel Corredor / Laravel-Vue-TailwindCSS

Make sure to change the API KEY under resources/js/Global.js
    - Replace APIKEYFORVINDECODER for the X-RapidAPI-Key


# Documentation:


## DashboardController File

The `DashboardController` is responsible for handling the dashboard functionality in the application.

### Methods

#### `index()`

Displays the dashboard page.

- If the user's phone is verified (`phone_verified_at` is not null), it renders the `dashboard` view with the user data.
- If the user's phone is not verified, it redirects to the `validatePhone` route.

#### `validatePhone()`

Validates the user's phone.

- If the user's phone is not verified (`phone_verified_at` is null), it renders the `dashboard` view with the user data.
- If the user's phone is already verified, it redirects to the `dashboard` route.





## ErrorLogController File

The `ErrorLogController` is responsible for handling the logging of errors in the application.

### Methods

#### `store(Request $request)`

Stores an error log entry.

- Validates the request data, requiring the `error` and `page` fields.
- Creates a new log entry in the database using the `Log` model, with the error message and page information.
- Returns a JSON response with a success message.





## HomeController File

The `HomeController` is responsible for handling the application's home page and user check functionality.

### Methods

#### `index()`

Shows the application dashboard.

- Retrieves the authenticated user using `Auth::user()`.
- Renders the `main` view, passing the user data to the view.

#### `userCheck()`

Performs a user check.

- Dumps and dies with the message "Hello".





## OtpController File

The `OtpController` is responsible for handling OTP (One-Time Password) functionality, including sending OTP codes and verifying phone numbers.

### Methods

#### `sendOtp(Request $request, Client $client)`

Sends an OTP code to the provided phone number.

- Retrieves the OTP code and phone number from the request.
- Sends an HTTP POST request to the Telesign API to send the OTP code via SMS.
- Returns a JSON response with a success message if the request is successful, or an error message if it fails.

#### `verifyPhone(Request $request)`

Verifies the phone number after successful OTP validation.

- Retrieves the authenticated user ID from the request.
- Updates the `phone_verified_at` field of the user model to the current timestamp.
- Returns a JSON response with a success message if the verification is successful, or an error message if it fails.




## app.js File

The `app.js` file is the entry point for the Vue.js application. It sets up the Vue router and mounts the main `App` component.

### Dependencies

- Vue.js
- Vue Router







## validationRules.js File

The `validationRules.js` file contains custom validation rules for the VeeValidate library.

### Rules

#### `required`

Checks if a value is present and not empty.

- Returns an error message if the value is empty.

#### `username`

Validates a username.

- Checks if the username is at least 4 characters long.
- Checks if the username contains only letters and numbers.

#### `password`

Validates a password.

- Checks if the password is at least 8 characters long.
- Checks if the password contains at least one symbol (@#$%), and at least one uppercase letter.

#### `email`

Validates an email address.

- Checks if the email address has a valid format.

#### `phoneFormat`

Validates a phone number format.

- Checks if the phone number is in the format +XX XXX XX XXXX.

#### `vinRuler`

Validates a Vehicle Identification Number (VIN).

- Checks if the VIN is 17 characters long.
- Checks if the VIN contains only valid characters (letters A-H, J-N, P-R, Z, and digits).
- Checks if the VIN does not contain spaces.







## getToken.js File

The `getToken.js` file contains a function to retrieve a CSRF token using Axios.

### Function

#### `getToken()`

Retrieves a CSRF token by making a GET request to the `/sanctum/csrf-cookie` endpoint.

- Uses Axios to send a GET request to the `/sanctum/csrf-cookie` endpoint.
- The CSRF token is automatically stored in the browser's cookie jar.







## App.vue File

The `App.vue` file is the root component of the Vue.js application.




## Scafolding of VUE:

- Templates: 2 almost static components:


## FooterTemplate.vue

The `FooterTemplate.vue` file represents the footer component of the application.

## HeaderTemplate.vue

The `HeaderTemplate.vue` file represents the header component of the application.








- Views: files that inclue each of the views 


## DashboardView.vue

The `DashboardView.vue` file represents the dashboard view component of the application.

### Template

The template section defines the HTML structure of the dashboard view. It includes the following elements:

- A header component (`HeaderTemplate`) that displays the authenticated status.
- A form for searching a VIN number, including an input field (`Field`), error message display (`ErrorMessage`), and a submit button.
- Conditional rendering based on the search results:
  - If search results exist and the VIN data is not false, it displays the search results section.
  - If the VIN data is false, it displays an error message.
- The search results section displays vehicle information and salvage information if available.
- A footer component (`FooterTemplate`) is included at the bottom of the view.

### Script

The script section defines the Vue component logic for the dashboard view. It includes the following:

- Import statements for the required components (`HeaderTemplate`, `FooterTemplate`, `Form`, `Field`, `ErrorMessage`).
- Import statements for external libraries (`axios`, `Swal`) and a global configuration file (`Global`).
- The component name is set to `DashboardView`.
- The component defines props for `authenticated` and `user`.
- The component defines data properties for `vin` and `searchResults`.
- The component includes the `Form`, `Field`, `ErrorMessage`, `HeaderTemplate`, and `FooterTemplate` components.
- The component defines methods for searching the VIN number (`searchVIN`), checking for salvage information (`salvageChecks`), and logging errors (`logError`).



## HomeView.vue

The `HomeView.vue` file represents the home view component of the application.

### Template

The template section defines the HTML structure of the home view. It includes the following elements:

- A header component (`HeaderTemplate`) that displays the header of the application.
- A container with a maximum width and centered alignment, containing a card-like element.
- The card-like element displays a welcome message and a prompt to login or register.
- A footer component (`FooterTemplate`) is included at the bottom of the view.

### Script

The script section defines the Vue component logic for the home view. It includes the following:

- Import statements for the required components (`HeaderTemplate`, `FooterTemplate`).
- The component name is set to `HomeView`.
- The component includes the `HeaderTemplate` and `FooterTemplate` components.
- There are no data properties or methods defined in this component.



## LoginView.vue

The `LoginView.vue` file represents the login view component of the application.

### Template

The template section defines the HTML structure of the login view. It includes the following elements:

- A header component (`HeaderTemplate`) that displays the header of the application.
- A container with a maximum width and centered alignment.
- A title and description for the login form.
- A form for entering the email and password, including input fields (`Field`), error message display (`ErrorMessage`), and a submit button.
- A checkbox for remembering the login.
- A footer component (`FooterTemplate`) is included at the bottom of the view.

### Script

The script section defines the Vue component logic for the login view. It includes the following:

- Import statements for the required components (`HeaderTemplate`, `FooterTemplate`), libraries (`axios`, `Swal`), and utility functions (`getToken`).
- The component name is set to `LoginView`.
- The component defines props for `authenticated` and `user`.
- The `created` lifecycle hook is used to check if the user is already authenticated and redirect to the dashboard if so.
- The component includes the `HeaderTemplate` and `FooterTemplate` components.
- The component defines data properties for `email`, `password`, and `remember`.
- The component includes the `Form`, `Field`, and `ErrorMessage` components for form validation.
- The `submitForm` method is used to handle form submission. It sends a POST request to the `/login` endpoint with the email, password, and remember values. It handles success and error responses using `Swal` for notifications and redirects to the dashboard on successful login.


## RegisterView.vue

The `RegisterView.vue` file represents the registration view component of the application.

### Template

The template section defines the HTML structure of the registration view. It includes the following elements:

- A header component (`HeaderTemplate`) that displays the header of the application.
- A container with a maximum width and centered alignment.
- A title and description for the registration form.
- A form for entering the name, username or email, password, password confirmation, and phone number, including input fields (`Field`), error message display (`ErrorMessage`), and a submit button.
- A footer component (`FooterTemplate`) is included at the bottom of the view.

### Script

The script section defines the Vue component logic for the registration view. It includes the following:

- Import statements for the required components (`HeaderTemplate`, `FooterTemplate`), libraries (`axios`, `Swal`), and utility functions (`getToken`).
- The component name is set to `RegisterView`.
- The component includes the `HeaderTemplate` and `FooterTemplate` components.
- The component defines data properties for `isRegister` and `form`.
- The component includes the `Form`, `Field`, and `ErrorMessage` components for form validation.
- The `submitRegistrationForm` method is used to handle form submission. It sends a POST request to the `/register` endpoint with the registration form data. It handles success and error responses using `Swal` for notifications and redirects to the login page on successful registration.


## ValidationView.vue

The `ValidationView.vue` file represents the validation view component of the application.

### Template

The template section defines the HTML structure of the validation view. It includes the following elements:

- A header component (`HeaderTemplate`) that displays the header of the application.
- A container with a maximum width and centered alignment.
- A title and welcome message for the dashboard.
- Conditional rendering based on the phone validation status:
  - If the user's phone number has not been validated, it displays instructions to start the validation process and enter the verification code.
  - If the user has started the validation process, it displays an input field for entering the verification code.
- A button to start the validation process or submit the verification code.
- A footer component (`FooterTemplate`) is included at the bottom of the view.

### Script

The script section defines the Vue component logic for the validation view. It includes the following:

- Import statements for the required components (`HeaderTemplate`, `FooterTemplate`), libraries (`axios`, `Swal`), and utility functions (`getToken`).
- The component name is set to `ValidationView`.
- The component includes the `HeaderTemplate` and `FooterTemplate` components.
- The component defines data properties for `showInput`, `verificationCode`, and `verificationCodeSent`.
- The component defines methods for starting the validation process (`startValidation`) and submitting the verification code (`submitVerificationCode`).
- The `logError` method is used to handle error logging and display error notifications using `Swal`.







##############################################Going to Routes of Laravel

## api.php

The `api.php` file contains the API routes for your application.

### Authentication Routes

- `/user` (GET): Returns the authenticated user's information.
- `/check-authentication` (GET): Checks if a user is authenticated and returns the authentication status and user information.

### Error Logging Routes

- `/error-logger` (POST): Stores an error log entry. Expects an `error` and `page` parameter in the request body.

### OTP Routes

- `/send-otp` (POST): Sends an OTP (One-Time Password) to a phone number. Expects a `phoneNumber` and `verifyCode` parameter in the request body.
- `/verifyPhone` (POST): Verifies the OTP for a phone number. Expects a `userId` parameter in the request body.



## web.php

The `web.php` file contains the web routes for your application.

### Authentication Routes

- `/login` (GET): Renders the login view.
- `/register` (GET): Renders the registration view.
- `/` and `/home` (GET): Renders the home view.

### Dashboard Routes

- `/dashboard` (GET): Renders the dashboard view. Requires authentication.
- `/validatePhone` (GET): Renders the phone validation view. Requires authentication.




















########### General Scafolding of relevant files #############

```
|-vin-checker/
|  |- app/
|  |  |- Http/
|  |  |  |- Controllers/
|  |  |  |  |- DashboardController.php
|  |  |  |  |- ErrorLogController.php
|  |  |  |  |- HomeController.php
|  |  |  |  |- OtpController.php
|  |
|  |- resources/
|  |  |- css/
|  |  |  |- app.css
|  |  |- js/
|  |  |  |- components/
|  |  |  |  |- templates/
|  |  |  |  |  |- FooterTemplate.vue
|  |  |  |  |  |- HeaderTemplate.vue
|  |  |  |  |- views/
|  |  |  |  |  |- DashboardView.vue
|  |  |  |  |  |- HomeView.vue
|  |  |  |  |  |- LoginView.vue
|  |  |  |  |  |- RegisterView.vue
|  |  |  |  |  |- ValidationView.vue
|  |  |  |  |- App.vue
|  |  |  |  |- getToken.js
|  |  |  |  |- validationRules.js
|  |  |  |- app.js
|  |  |  |- Global.js
|  |  |- views/
|  |  |  |- dashboard.blade.php
|  |  |  |- main.blade.php
|  |
|  |- routes/
|  |  |- api.php
|  |  |- web.php
|  |
|  |- package.json
|  |- tailwind.config.js
|  |- postcss.config.js
|  |- tailwind.config.js
|  |- vite.config.js
|- LICENSE
|- README.md
```