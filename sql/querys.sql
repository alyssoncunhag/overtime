CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único
    nome VARCHAR(100) NOT NULL,        -- Nome do usuário
    email VARCHAR(100) UNIQUE NOT NULL, -- E-mail, deve ser único
    senha VARCHAR(255) NOT NULL,       -- Senha criptografada
    permissoes TEXT                    -- Permissões armazenadas como JSON ou texto
);

CREATE TABLE jogos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT,
    data_lancamento DATE,
    imagem VARCHAR(255)
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT
);

CREATE TABLE times (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    pais VARCHAR(50),
    descricao TEXT,
    imagem VARCHAR(255)
);

CREATE TABLE torneios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    id_jogo INT,
    descricao TEXT,
    data_inicio DATE,
    data_fim DATE,
    FOREIGN KEY (id_jogo) REFERENCES jogos(id)
);

CREATE TABLE noticias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT NOT NULL,
    imagem VARCHAR(255),
    id_categoria INT,
    id_autor INT,
    data_publicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id),
    FOREIGN KEY (id_autor) REFERENCES usuarios(id)
);

CREATE TABLE relacao_noticia_torneio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_noticia INT,
    id_torneio INT,
    FOREIGN KEY (id_noticia) REFERENCES noticias(id),
    FOREIGN KEY (id_torneio) REFERENCES torneios(id)
);

CREATE TABLE relacao_noticia_time (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_noticia INT,
    id_time INT,
    FOREIGN KEY (id_noticia) REFERENCES noticias(id),
    FOREIGN KEY (id_time) REFERENCES times(id)
);

CREATE TABLE relacao_noticia_jogo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_noticia INT,
    id_jogo INT,
    FOREIGN KEY (id_noticia) REFERENCES noticias(id),
    FOREIGN KEY (id_jogo) REFERENCES jogos(id)
);

