# Installation

Follow these steps to setup the project : 

- `cd Backend`
- `composer i`
- Configure your local DB access in the `.env` file
- `php init_db.php`

Feel free to test these commands

- `./fleet create <userId>`
- `./fleet register-vehicle <fleetId> <vehiclePlateNumber>`
- `./fleet localize-vehicle <fleetId> <vehiclePlateNumber> lat lng [alt]`