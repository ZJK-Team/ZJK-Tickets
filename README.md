Tutorial na funkcni otest

celou složku z githubu musíme vložit do MAMP interní složky která je na C:\MAMP\htdocs\"název složky"

v phpmyadmin musíte vytvořit DB "auth_roles" poté vytvořit 3 tabulky pře SQL příkazy

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `status` varchar(50) COLLATE utf8_czech_ci DEFAULT 'Otevřený',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE `ticket_messages` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf8_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8_czech_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

při prvním otevření stránky si můžete vytvořit několik uživatelů je to jedno ale pokud chcete dělat opravdový otest musíte si jednoho uživatele v phpmyadmin přepnou na admina
![image](https://github.com/user-attachments/assets/4e00cb28-cb28-49ca-8a4d-d173b0a19df3)

!! pokud zapomenete heslo od uživatele budete muset uživatele odstranit, NEMĚŇTE ZAHESHOVANÉ HESLO V TABULCE USER STRANKA PAK NEBUDE FUNGOVAT.

!! Pokud budete dělat nějaké upravy, prosím o normální zapsání popisu o úpravě. Také poprosím o dodržení vytvořené hierarchie tzn. pouze jeden header a footer (header.php a footer.php) každý z nich pouze jeden css soubor se stejným názvem a pokud možno kluci z frontendu moc nehrabejte do věcí co jsou ve "\<?php ... ?>"
