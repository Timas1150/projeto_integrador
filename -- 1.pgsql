-- 1. Usuários (autenticação do sistema)
CREATE TABLE IF NOT EXISTS usuarios (
    id SERIAL PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. O Time Histórico e sua História
CREATE TABLE IF NOT EXISTS times_historicos (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL,
    nome_clube VARCHAR(100) NOT NULL,        
    temporada VARCHAR(20) NOT NULL,         
    tecnico VARCHAR(100) NOT NULL,          
    posicao_final VARCHAR(50) NOT NULL,      

    
    historia_temporada TEXT NOT NULL,       
    momento_marcante TEXT,                   
    jogadores_chave TEXT,                    
    
    escudo_url VARCHAR(255),               
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_time_usuario FOREIGN KEY (usuario_id) 
    REFERENCES usuarios(id) ON DELETE CASCADE
);