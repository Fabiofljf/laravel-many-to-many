# Esercizio

## aggiungete la possibilitá di caricare un file quando si crea/modifica un post

1. Modificare il filesystems.php da Local a Public;
2. Creare un symlink “storage” nella cartella public che punta alla cartella storage/app/public:
- php artisan storage:link;
3. Nel PostController in store, update e delete: verifico se la richiesta contiene un file e do la possibilità di eliminarlo;
4. Uso la funzione asset() nel index e nello show e sistemo nel create e nel edit il type dell'input image da text a file;
5. Modifica nell'edit anche il campo per visualizzarla.





## create una mailable per confermare all'utente che il post é stato inviato
