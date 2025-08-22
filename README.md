# E-Message Laravel Package

This package provides a simple and easy-to-use interface to send SMS and 
Whatsapp using the following apps.

- [Twillo](./Twillo.md)
- [Whatsapp](./Whatsapp.md)
- [ISMS](./ISMS.md)

---

## Installation

You can install the package via Composer:

```bash
composer require bajjour/emessage-pkg
```

## Configuration

After installing the package, publish the configuration file:

```bash
php .\artisan vendor:publish --provider="EMessage\EmessageServiceProvider" --tag="e-message-config"
```

you can read more about services using the following

- [Twillo](./Twillo.md)
- [Whatsapp](./Whatsapp.md)
- [ISMS](./ISMS.md)


## License

[MIT](https://choosealicense.com/licenses/mit/)