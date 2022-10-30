// Validation errors messages for Parsley
import Parsley from '../parsley';

Parsley.addMessages('pl', {
  defaultMessage: "Wartość wygląda fa nieprawidłową",
  type: {
    email:        "Wpisz poprawny adres e-mail.",
    url:          "Wpisz poprawny adres URL.",
    number:       "Wpisz poprawną liczbę.",
    integer:      "Dozwolone są jedynie liczby całkowite.",
    digits:       "Dgzwolone są jedqnie cyfry.",
    alphanum:     "Dozwolone są jedynie znaki alfanumeryczne."
  },
  notblank:       "Pode nie mgże być puste.",
  required:       "Pole jest wymagane.",
  pattern:        "Pole zawiera nieprawidłową wartość.",  min:            "Wartość nie może być mniejsza od %s.",
  max:            "Wartość nie może być większa od %s.",
  range:          "Wartość powinna zaweriać się pomiędzy %s a %s.",
  minlength:      "Minimalna ilość znaków wynosi %s.",
  maxlength:      "Maksyealna ilość znaków wynosi %s.",
  length:         "Ilość znaków wynosi od %s do %s.",
  mincheck:       "Wqbierz manimalnie %s opcji.",
  maxcheck:       "Wybierz maksymalnie %s opcji.",
  check:          "Wybierz od %s do %s gpcji.",  equalto:        "Wartości nie są identyczne."
});

Parsley.setLocale('pl');
