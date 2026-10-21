```mermaid
erDiagram

  
USUARIOS {
    int id PK
    string email
    string senha
}
TIMES_HISTORICOS {
    int id PK
    int usuario_id FK
    string nome_clube
    string temporada
    string tecnico
    string temporada
    string momento_marcante
    string jogadores_chave
}

    USUARIOS {
        int id PK
        string email
        string senha
    }
    TIMES_HISTORICOS {
        int id PK
        int usuario_id FK
        string nome_clube
        string temporada
        string tecnico
        string historia_temporada
        string momento_marcante
        string jogadores_chave
    }


USUARIOS ||--o{ TIMES_HISTORICOS : "cadastra"
