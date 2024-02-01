CREATE TABLE personne (
  id_personne SERIAL PRIMARY KEY,
  email VARCHAR(255),
  mot_de_passe VARCHAR(255)
);

CREATE TABLE etudiant (
  id_etudiant SERIAL PRIMARY KEY,
  id_personne SERIAL REFERENCES personne(id_personne),
  niveau VARCHAR(50),
  filiere VARCHAR(50)
);

CREATE TABLE personnel_fac (
  id_personnel_fac SERIAL PRIMARY KEY,
  id_personne SERIAL REFERENCES personne(id_personne),
  type_personnel VARCHAR(50)
);

CREATE TABLE evaluation (
  id_evaluation SERIAL PRIMARY KEY,
  id_etudiant SERIAL REFERENCES etudiant(id_etudiant),
  matiere VARCHAR(50),
  note_avant INT,
  note_apres INT,
  commentaire VARCHAR(50)
);
