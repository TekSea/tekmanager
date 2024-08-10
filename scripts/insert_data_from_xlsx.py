import pandas as pd
import mysql.connector
from mysql.connector import Error

# Dados de conexão com o banco de dados
db_config = {
    "host": "localhost",
    "port": 3306,
    "user": "root",
    "password": "TRQy2lVXtX35nyqn",
    "database": "TEKMANAGER",
    "charset": "utf8mb4"
}

# Função para conectar ao banco de dados
def create_connection(db_config):
    connection = None
    try:
        connection = mysql.connector.connect(
            host=db_config['host'],
            port=db_config['port'],
            user=db_config['user'],
            password=db_config['password'],
            database=db_config['database'],
            charset=db_config['charset']
        )
        print("Conexão ao MySQL realizada com sucesso")
    except Error as e:
        print(f"Erro ao conectar ao MySQL: {e}")
    return connection

# Função para buscar o ID do cliente com base no nome
def get_client_id(connection, cliente_name):
    cursor = connection.cursor()
    sql = "SELECT id FROM clientes WHERE nome = %s"
    cursor.execute(sql, (cliente_name,))
    result = cursor.fetchone()
    cursor.fetchall()
    return result[0] if result else None

# Função para buscar o ID do estoque com base na referência do sistema
def get_stock_id(connection, ref_sistema):
    cursor = connection.cursor()
    sql = "SELECT id FROM estoque WHERE ref_sistema = %s"
    cursor.execute(sql, (ref_sistema,))
    result = cursor.fetchone()
    cursor.fetchall()
    return result[0] if result else None

# Função para inserir dados na tabela clientes
def insert_clients_data(connection, df):
    print("Inserindo dados na tabela clientes")
    cursor = connection.cursor()
    for _, row in df.iterrows():
        sql = """
        INSERT INTO clientes (id, cnpj_cpf, nome, nome_fantasia, uf, cidade, representante, situacao)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s)
        """        
        cursor.execute(sql, (
            row['Código'], 
            row['CNPJ/CPF'] if pd.notnull(row['CNPJ/CPF']) else "",            
            row['Nome'] if pd.notnull(row['Nome']) else "",
            row['Nome Fantasia'] if pd.notnull(row['Nome Fantasia']) else "",
            row['UF'] if pd.notnull(row['UF']) else "",
            row['Cidade'] if pd.notnull(row['Cidade']) else "",
            row['Representante'] if pd.notnull(row['Representante']) else "",
            row['Situação'] if pd.notnull(row['Situação']) else "ativo"
        ))
    connection.commit()
    print("Dados inseridos com sucesso")

# Função para inserir dados na tabela estoque
def insert_stock_data(connection, df):
    print("Inserindo dados na tabela estoque")
    cursor = connection.cursor()
    for _, row in df.iterrows():
        sql = """
        INSERT INTO estoque (id, ref_sistema, ncm, produto)
        VALUES (%s, %s, %s, %s)
        """
        cursor.execute(sql, (
            row['Código'], 
            row['Ref. Sistema'] if pd.notna(row['Ref. Sistema']) else None, 
            row['NCM'] if pd.notna(row['NCM']) else None, 
            row['Produto'] if pd.notna(row['Produto']) else None
        ))
    connection.commit()
    print("Dados inseridos com sucesso")

# Função para inserir dados na tabela rastreabilidade
def insert_traceability_data(connection, df):
    print("Inserindo dados na tabela rastreabilidade")
    cursor = connection.cursor()
    for _, row in df.iterrows():
        cliente_id = get_client_id(connection, row['CLIENTE']) if pd.notna(row['CLIENTE']) else None
        estoque_id = get_stock_id(connection, row['REF. SISTEMA']) if pd.notna(row['REF. SISTEMA']) else None

        sql = """
        INSERT INTO rastreabilidade (
            numero_serie, data_geracao, responsavel_criacao, cliente_id, estoque_id, pv, op,
            codigo_net, ref_sistema, produto, obra_alocada, n_fatura, data_enviado, garantia_dias, expira_garantia,
            status_garantia, condicao_garantia
        )
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """
        cursor.execute(sql, (
            row['NÚMERO SÉRIE'] if pd.notna(row['NÚMERO SÉRIE']) else None,  
            row['DATA GERAÇÃO'] if pd.notna(row['DATA GERAÇÃO']) else None, 
            row['RESPONSÁVEL CRIAÇÃO'] if pd.notna(row['RESPONSÁVEL CRIAÇÃO']) else None,
            cliente_id, estoque_id, 
            row['PV'] if pd.notna(row['PV']) else None, 
            row['OP'] if pd.notna(row['OP']) else None, 
            row['CÓDIGO (NET)'] if pd.notna(row['CÓDIGO (NET)']) else None,
            row['REF. SISTEMA'] if pd.notna(row['REF. SISTEMA']) else None, 
            row['PRODUTO'] if pd.notna(row['PRODUTO']) else None, 
            row['OBRA ALOCADA'] if pd.notna(row['OBRA ALOCADA']) else None, 
            row['N FFATURA'] if pd.notna(row['N FFATURA']) else None,
            row['DATA ENVIADO'] if pd.notna(row['DATA ENVIADO']) else None, 
            row['GARANTIA(dias)'] if pd.notna(row['GARANTIA(dias)']) else None, 
            row['EXPIRA GARANTIA'] if pd.notna(row['EXPIRA GARANTIA']) else None,
            row['STATUS GARANTIA'] if pd.notna(row['STATUS GARANTIA']) else None, 
            row['CONDIÇÃO DE GARANTIA'] if pd.notna(row['CONDIÇÃO DE GARANTIA']) else None
        ))
    connection.commit()
    print("Dados inseridos com sucesso")

# Função principal para ler os arquivos Excel e inserir os dados no banco de dados
def main():
    # Lendo os arquivos Excel
    clientes_df = pd.read_excel('/mnt/f/Work/teksea/tekmanager/scripts/Consulta Clientes.xlsx')
    estoque_df = pd.read_excel('/mnt/f/Work/teksea/tekmanager/scripts/Consulta Estoque.xlsx')
    rastreabilidade_df1 = pd.read_excel('/mnt/f/Work/teksea/tekmanager/scripts/RASTREABILIDADE TEKSEA_DB_v2.xlsx', sheet_name='IND_NAVAL')
    rastreabilidade_df2 = pd.read_excel('/mnt/f/Work/teksea/tekmanager/scripts/RASTREABILIDADE TEKSEA_DB_v2.xlsx', sheet_name='TELECOM')
    

    # Conectando ao banco de dados
    connection = create_connection(db_config)
    if connection:
        # Inserindo dados nas tabelas de clientes e estoque
        insert_clients_data(connection, clientes_df)
        insert_stock_data(connection, estoque_df)

        # Inserindo dados na tabela de rastreabilidade
        insert_traceability_data(connection, rastreabilidade_df1)
        insert_traceability_data(connection, rastreabilidade_df2)
        
        connection.close()
        print("Dados inseridos com sucesso")

if __name__ == "__main__":
    main()
