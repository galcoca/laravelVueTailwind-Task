import { defineRule } from "vee-validate";

defineRule("required", (value) => {
    if (!value || !value.length) {
        return "This field is required";
    }
    return true;
});

defineRule("username", (value) => {
    let pattern = /^[a-zA-Z0-9]+$/
    if (!value) {
        return true;
    }
    if (value.length < 4) {
        return "Username must be at least 4 characters";
    }
    if (!pattern.test(value)) {
        return "Username can only contain letters and numbers";
    }
    return true;
});

defineRule("password", (value) => {
    let patternA = /[!@#$%^&*]/
    let patternB = /[A-Z]/
    if (!value) {
        return "This field is required";
    }
    if (value.length < 8 || !patternA.test(value) || !patternB.test(value)) {
        return "Password must be at least 8 characters, contain 1 symbol (@#$%), and at least 1 uppercase letter";
    }
    return true;
});

defineRule("email", (value) => {
    let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!value) {
        return true;
    }
    if (!pattern.test(value)) {
        return "Invalid email format";
    }
    return true;
});

defineRule("phoneFormat", (value) => {
    const phoneRegex = /^\+\d{2}(\s?\d{3}){2}\s?\d{4}$/;
    if (!phoneRegex.test(value)) {
        return "Phone number must be in the format +XX XXX XX XXXX";
    }
    return true;
});

defineRule("vinRuler", (value) => {
    const pattern = /^[A-HJ-NPR-Z\d]{17}$/;
    if (!value) {
      return true;
    }
    if (value.length !== 17) {
      return "All VINs are 17 characters in length—no longer, no shorter";
    }
    if (!pattern.test(value)) {
      return "Invalid VIN format. VINs can only contain letters A-H, J-N, P-R, Z, and digits.";
    }
    if (value.includes(" ")) {
      return "VINs cannot contain spaces";
    }
    return true;
  });