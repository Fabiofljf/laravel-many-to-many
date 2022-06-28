# Esercizio

## aggiungete la possibilitá di caricare un file quando si crea/modifica un post

1. Modificare il filesystems.php da Local a Public;
2. Creare un symlink “storage” nella cartella public che punta alla cartella storage/app/public:
- php artisan storage:link;
3. Nel PostController in store, update e delete: verifico se la richiesta contiene un file e do la possibilità di eliminarlo;
4. Uso la funzione asset() nel index e nello show e sistemo nel create e nel edit il type dell'input image da text a file;
5. Modifica nell'edit anche il campo per visualizzarla.


## create una mailable per confermare all'utente che il post é stato inviato
1. Modifico il file .env con le istruzioni di Mailtrap;
2. Creo un oggetto Mailable, che rappresenta il messaggio email che vogliamo inviare insieme al markdown in resource:
- php artisan make:mail (Nomedell'oggetto) --markdown=mail.markdown.admin-(Nomedell'oggetto);
3. Modifico il construct;
4. Creo la relativa view da restituire nella funzione build(). Questa view corrisponde al contenuto dell'email da inviare. Nella view possiamo usare Plain Text, Blade o Markdown.
5. Modifico componente dell'url in views\mian ['url' => '$post->slug']);
6. Modifico il controller con return e l'istanza dell'email;
7. Modifico la rotta;
