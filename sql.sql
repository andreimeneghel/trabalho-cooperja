-- Criar o banco de dados
CREATE SCHEMA IF NOT EXISTS `escola_db` DEFAULT CHARACTER SET utf8;
USE `escola_db`;

-- -----------------------------------------------------
-- Tabela de Usuários (tb_users)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,  -- Armazenamento de senha com hash
  `role` ENUM('aluno', 'professor') NOT NULL, -- Role de usuário (aluno ou professor)
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Tabela de Alunos (tb_alunos)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tb_alunos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  `nascimento` DATE NOT NULL,
  `tb_user_id` INT UNSIGNED NOT NULL,  -- Relacionamento com tb_users
  `tb_turma_id` INT UNSIGNED NOT NULL, -- Relacionamento com a turma
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_aluno_user` FOREIGN KEY (`tb_user_id`) REFERENCES `tb_users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_aluno_turma` FOREIGN KEY (`tb_turma_id`) REFERENCES `tb_turmas`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Tabela de Professores (tb_professores)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tb_professores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NOT NULL,
  `nascimento` DATE NOT NULL,
  `admissao` DATE NOT NULL,
  `tb_user_id` INT UNSIGNED NOT NULL,  -- Relacionamento com tb_users
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_professor_user` FOREIGN KEY (`tb_user_id`) REFERENCES `tb_users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Tabela de Turmas (tb_turmas)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tb_turmas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `tb_professor_id` INT UNSIGNED NOT NULL,  -- Relacionamento com tb_professores
  `tb_materia_id` INT UNSIGNED NOT NULL,    -- Relacionamento com tb_materias
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_turma_professor` FOREIGN KEY (`tb_professor_id`) REFERENCES `tb_professores`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_turma_materia` FOREIGN KEY (`tb_materia_id`) REFERENCES `tb_materias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Tabela de Matérias (tb_materias)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tb_materias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Tabela de Notas e Presença (tb_notas_presenca)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tb_notas_presenca` (
  `tb_aluno_id` INT UNSIGNED NOT NULL,
  `tb_materia_id` INT UNSIGNED NOT NULL,
  `presenca` INT NOT NULL,  -- 1 = Presente, 0 = Ausente
  `nota` DECIMAL(5,2) NOT NULL,  -- Nota do aluno na matéria
  PRIMARY KEY (`tb_aluno_id`, `tb_materia_id`),
  CONSTRAINT `fk_notas_presenca_aluno` FOREIGN KEY (`tb_aluno_id`) REFERENCES `tb_alunos`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_notas_presenca_materia` FOREIGN KEY (`tb_materia_id`) REFERENCES `tb_materias`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Índices e configurações adicionais
-- -----------------------------------------------------
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

