# freelahub
Foi feita a seguinte organização dos arquivos:
```
freelahub
├── classes
│   ├── Auth.php
│   ├── Crud.php
│   ├── Explorador.php
│   ├── Perfil.php
│   └── Usuario.php
├── config
│   └── database.php
├── index.html
├── outros-doc
│   ├── BD_freelahub_Pedro.sql
│   ├── BD_freelahub.sql
│   ├── Diagrama de Fluxo 2.pdf
│   ├── Diagrama de Fluxo.pdf
│   └── UML.pdf
├── public
│   ├── atualizar_cadastro.php
│   ├── cadastro.php
│   ├── consultar.php
│   ├── css
│   │   └── style.css
│   ├── excluir.php
│   ├── fonts
│   │   ├── Poppins-Black.ttf
│   │   ├── Poppins-ExtraBold.ttf
│   │   ├── Poppins-Medium.ttf
│   │   ├── Poppins-Regular.ttf
│   │   └── Poppins-SemiBoldItalic.ttf
│   ├── images
│   │   ├── backgroundh1.png
│   │   ├── backgroundh2.png
│   │   ├── backgroundhome3.png
│   │   ├── logo01.png
│   │   ├── logo02.png
│   │   ├── logo03.png
│   │   ├── logo 04.png
│   │   ├── profissionaish2.png
│   │   ├── profissionaish3.png
│   │   ├── profissionais.png
│   │   └── visto.png
│   ├── login.php
│   └── logout.php
└── README.md

```

No Banco de Dados, mudei o tipo de dado de telefone para VARCHAR. Corrigi também esse último - estava escrito decricao. Descobri quando o código não estava funcionando corretamente.

Na autenticação, o programa precisa ser melhorado. O administrador (adm@freela.com) está hardcoded. O ideal seria criar na tabela um atributo que diferenciaria usuario normal de administrador.

Façam as alterações que julgarem necessárias. Devem ter muitas.

Por ora é isso!
