-- Criação do banco de dados
create database bd_tcc;

-- Uso do banco de dados criado
use bd_tcc;


create table instituicao(
	id_instituicao int primary key  auto_increment not null,
    nome_instituicao varchar(200) not null,
    email varchar(200) not null,
    senha varchar(20) not null
);

insert into instituicao(nome_instituicao,email,senha) values
	("TheSchool","tcc@email.com","1234");


-- Criação da tabela disciplinas
create table disciplinas(
    id_disciplina int auto_increment primary key,
    nome_disciplina varchar(100) unique not null
);
insert into disciplinas (nome_disciplina) values
    ('Português'),
    ('Matemática'),
    ('História'),
    ('Ciências'),
    ('Geografia'),
    ('Não Possui');
    
-- Criação da tabela serie
create table serie(
    id_serie int auto_increment primary key,
    nome_serie varchar(25) not null,
    disciplina1 int not null,
    disciplina2 int not null,
    disciplina3 int not null,
    disciplina4 int not null,
    disciplina5 int not null
);

insert into serie(nome_serie,disciplina1,disciplina2,disciplina3,disciplina4,disciplina5) values
    ("6º Ano",1,2,3,4,5),
    ("7º Ano",1,2,3,4,5),
    ("8º Ano",1,2,3,4,5),
    ("9º Ano",1,2,3,4,5);

-- Criação da tabela situacao
create table situacao(
    id_situacao int auto_increment primary key,
    nome_situacao varchar(20) unique not null
);

insert into situacao(nome_situacao) values
    ("Ativo"),
    ("Inativo");

-- Criação da tabela tipo_usuario
create table tipo_funcionario(
    id_tipo_funcionario int auto_increment primary key,
    tipo varchar(20) not null
);

insert into tipo_funcionario(tipo) values 
    ("Administrativo"),
    ("Professor");

-- Criação da tabela instituicao
create table funcionario_instituicao(
    id_funcionario int auto_increment primary key,
    cpf_funcionario char(11) unique not null,
    nome_funcionario varchar(200) not null,
    data_nascimento_funcionario date not null,
    sexo_funcionario enum("M","F") not null,
    situacao_funcionario int not null,
    contato_funcionario varchar(11) not null,
	tipo_funcionario int not null,
    email varchar(120) not null unique,
    senha varchar(255) not null,
    foreign key (tipo_funcionario) references tipo_funcionario(id_tipo_funcionario),
    foreign key (situacao_funcionario) references situacao(id_situacao)
);

-- Criação da tabela professor
create table professor(
    id_professor int auto_increment primary key,
    id_prof_func int not null,
    disciplina_professor int not null,
    foreign key (id_prof_func) references funcionario_instituicao(id_funcionario),
    foreign key (disciplina_professor) references disciplinas(id_disciplina)
);

-- Criação da tabela aluno
create table aluno(
    id_aluno int auto_increment primary key,
    cpf_aluno char(11) unique not null,
    nome_aluno varchar(200) not null,
    data_nascimento_aluno date not null,
    sexo_aluno enum("M","F") not null,
    situacao_aluno int not null,
    contato_aluno varchar(11) not null,
    email varchar(120) not null unique,
    senha varchar(255) not null,
    foreign key (situacao_aluno) references situacao(id_situacao)
);


-- Criação da tabela salas
create table salas(
    id_sala int auto_increment primary key,
    ano_sala int not null,
    serie_sala int not null,
	ativa_sala int not null,
    foreign key (ativa_sala) references situacao(id_situacao),
    foreign key (serie_sala) references serie(id_serie)
    
);

-- Criação da tabela sala_alunos
create table sala_alunos(
    id_sa int auto_increment primary key,
    aluno_sa int not null,
    sala_sa int not null,
    ativo_sa int not null,
    foreign key (aluno_sa) references aluno(id_aluno),
    foreign key (sala_sa) references salas(id_sala),
    foreign key (ativo_sa) references situacao(id_situacao)
);

create table sala_professor(
	id_sp int auto_increment primary key,
    professor_sp int not null,
    sala_sp int not null,
    foreign key (professor_sp) references professor(id_professor),
    foreign key (sala_sp) references salas(id_sala)
);

-- Criação da tabela aulas
create table aulas(
    id_aula int auto_increment primary key,
    data_aula timestamp not null,
    sala_aula int not null,
    disciplina_aula int not null,
    foreign key (disciplina_aula) references professor(disciplina_professor)
);

-- Criação da tabela presença_aulas
create table presenca_aulas(
    id_presenca int auto_increment primary key,
    aluno_presenca int not null ,
    aula_presenca enum("P","A") not null,
    aula_realizada int not null,
    foreign key (aluno_presenca) references aluno(id_aluno),
    foreign key (aula_realizada) references aulas(id_aula)
);

create table bimestres(
	id_bimestre int auto_increment primary key,
    nome_bimestre varchar(20)
);

insert into bimestres(nome_bimestre) values
	("1º Bimestre"),
	("2º Bimestre"),
	("3º Bimestre"),
	("4º Bimestre");

create table notas(
	id_nota int primary key auto_increment,
    id_aluno_nota int not null,
    id_sala_nota int not null,
    foreign key (id_aluno_nota) references sala_alunos(aluno_sa),
    foreign key (id_sala_nota) references salas(id_sala)
);


create table notas_aluno(
	id_na int primary key auto_increment,
    disciplina_na int not null,
    nota_na int not null,
    bimestre_na int not null,
    nota1 float,
    nota2 float,
    nota3 float,
    media float,
    foreign key (disciplina_na) references professor(disciplina_professor),
    foreign key (nota_na) references notas(id_nota),
    foreign key (bimestre_na) references bimestres(id_bimestre)
);

