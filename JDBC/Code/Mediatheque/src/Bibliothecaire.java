import java.io.*;
import java.sql.*;
import java.util.*;

import org.apache.poi.hssf.usermodel.HSSFCell;
import org.apache.poi.hssf.usermodel.HSSFRow;
import org.apache.poi.hssf.usermodel.HSSFSheet;
import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.poifs.filesystem.POIFSFileSystem;
import org.apache.poi.ss.usermodel.*;

public class Bibliothecaire {

	private final static Connection conn = openConnection();
	private final static String NAME_FILE = "data";
	
	public static void ln(int ligne) {
		for (int i = 0; i < ligne; i++) {
			System.out.println();
		}
	}	
	
	public static Connection openConnection () {
		Connection co=null;
		try {
			Class.forName("com.mysql.jdbc.Driver");
			
			// Connexion à ma base personnelle pour tester en dehors de l'IUT.
			//co = DriverManager.getConnection("jdbc:mysql://localhost/mediatheque?characterEncoding=utf-8", "root", "");
			
			//Connexion à la base du projet accsessible seulement à l'IUT.
			co = DriverManager.getConnection("jdbc:mysql://projets.iut-orsay.fr/sae-s3-hleroux", "sae-s3-hleroux", "7c68dplcvZNYyKfl");
			
			ln(1);
			
			System.out.println("				   CONNEXION REUSSIE !");
			ln(2);
		}
		catch (ClassNotFoundException e){
			ln(1);
			System.out.println("il manque le driver");
			System.exit(1);
		}
		catch (SQLException e) {
			ln(1);
			//System.out.println("impossible de se connecter a  l'url : ");
			e.printStackTrace();
			System.exit(1);
		}
		return co;
	}	
	
	public static ResultSet result (String requete, Connection conn, int type){
		ResultSet res=null;
		try {
			Statement st;
			if (type==0){
				st=conn.createStatement();}
			else {
				st=conn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE, ResultSet.CONCUR_READ_ONLY);
			};
			res = st.executeQuery(requete);
		}
		catch (SQLException e){
			System.out.println("Probleme lors de l'execution de la requete : "+requete);
		};
		return res;
	}
	
	
	public static String upperCaseFirst(String val) {
		char[] arr = val.toCharArray();
		arr[0] = Character.toUpperCase(arr[0]);
		return new String(arr);
	}	
	
	public static boolean present(Object val, String attribut, String table) {	
		try {
			Statement st = conn.createStatement();
			ResultSet rs = st.executeQuery("SELECT * FROM " + table + " WHERE " + attribut + " LIKE '"+val+"'");
			if(rs.next())
				return true;
		}
		catch(Exception err)
		{
			System.out.println("DB ERROR: "+err);
		}
		return false;
	}
	
	public static String gestionScannerString(Scanner sc) {
		try {
			String s = sc.next();
			return s;
		}
		catch(java.util.InputMismatchException e) {
			ln(1);
			System.out.println(" Vous n'avez pas entre de chaine de caractere");
			sc.nextLine();
		}
		return null;
	}
	
	public static int gestionScannerInt(Scanner sc) {
		try {
			int i = sc.nextInt();
			return i;
		}
		catch(java.util.InputMismatchException e) {
			ln(1);
			System.out.println(" Vous n'avez pas entre un entier");
			sc.nextLine();
		}
		return -1;
	}
	
	@SuppressWarnings("resource")
	public static HSSFSheet readFeuilleExcel(String nomFichier, int numFeuille) throws IOException {
		
		InputStream input = new FileInputStream("src/" + nomFichier + ".xls");
		
		POIFSFileSystem fs = new POIFSFileSystem(input);
		
		HSSFWorkbook wb = new HSSFWorkbook(fs);
		
		return wb.getSheetAt(numFeuille);
	}
	
	
	@SuppressWarnings("resource")
	public static int nbFeuilles(String nameFile) throws IOException{
		InputStream input = new FileInputStream("src/" + nameFile + ".xls");
		
		POIFSFileSystem fs = new POIFSFileSystem(input);
		
		HSSFWorkbook wb = new HSSFWorkbook(fs);
		
		return wb.getNumberOfSheets();
	}
	
	@SuppressWarnings("resource")
	public static String nomFeuille(int numFeuille) throws IOException {
		InputStream input = new FileInputStream("src/" + NAME_FILE + ".xls");
		
		POIFSFileSystem fs = new POIFSFileSystem(input);
		
		HSSFWorkbook wb = new HSSFWorkbook(fs);
		
		return wb.getSheetName(numFeuille);
	}
	
	
	
	@SuppressWarnings("rawtypes")
	public static ArrayList<ArrayList<Object>> tableau(String nomFichier, int numFeuille) throws IOException {
		
		ArrayList<ArrayList<Object>> fullList = new ArrayList<>(); // mon tableau rempli ligne par ligne
		
		HSSFSheet feuille = readFeuilleExcel(nomFichier ,numFeuille);
		
		Iterator lignes = feuille.rowIterator();
		
		while (lignes.hasNext()) {
			
			ArrayList<Object> list = new ArrayList<>(); // represente une ligne de mon fichier excel qui rempli mon tableau

			
			HSSFRow ligne = (HSSFRow)lignes.next();
			
			Iterator cells = ligne.cellIterator();
			
			while (cells.hasNext()) {
				
				HSSFCell cell = (HSSFCell) cells.next();
				CellType cellType = cell.getCellType();
				
				switch(cellType) {
				
				case NUMERIC : 
					list.add((int)cell.getNumericCellValue());
					break;
				case BOOLEAN :
					list.add(cell.getBooleanCellValue());
					break;
				case STRING :
					list.add(cell.getStringCellValue());
					break;
				default:
					break;
				};
				
			}
			fullList.add(list);
		}
		return fullList;
	}
	
	
	public static void affiche(ArrayList<ArrayList<Object>> array) {
		ln(1);
		
		for (int i = 0; i < array.size(); i++) {
			for (int j = 0; j < array.get(i).size(); j++) {
				if (array.get(i).indexOf(array.get(i).get(j)) == array.get(i).size()-1) {
					System.out.print(array.get(i).get(j));
				}
				else if (array.get(i).get(0) == array.get(i).get(j)) {
					System.out.print(" - " + array.get(i).get(j) + " | ");
				}
				else
					System.out.print(array.get(i).get(j) + " | ");
			}
			ln(2);
		}
		
	}
	
	
	public static void delete(String table) throws SQLException {
		PreparedStatement st = conn.prepareStatement("DELETE FROM " + upperCaseFirst(table));
		st.executeUpdate();
		System.out.println("Toutes les donnees ont ete supprimees de la table " + upperCaseFirst(table));
	}

	
	
	@SuppressWarnings("resource")
	public static void deleteAll(String nameFile) throws IOException, SQLException {
		
		InputStream input = new FileInputStream("src/" + nameFile + ".xls");
		
		POIFSFileSystem fs = new POIFSFileSystem(input);
		
		HSSFWorkbook wb = new HSSFWorkbook(fs);
		
		for (int i = 0; i < wb.getNumberOfSheets(); i++) {
			delete(wb.getSheetAt(i).getSheetName());
		}
	}
	
	
	public static int nbLignesTable(String nameFile, int numFeuille) throws IOException, SQLException{
		String req = "SELECT COUNT(*) AS 'nbLignes' FROM " + upperCaseFirst(readFeuilleExcel(nameFile, numFeuille).getSheetName());
		ResultSet rs = result(req, conn, 0);
		if(rs.next()) {
			return rs.getInt("nbLignes");
		}
		return 0;
	}
	
	public static boolean estPresent(String table, String cle, int val) throws SQLException {
		String req = "SELECT COUNT(*) FROM " + table + " WHERE " + cle + " = " + val;
		ResultSet rs = result(req, conn, 0);
		if (rs.next()) {
			if(rs.getInt("nb") == 0) {
				return false;
			}
		}
		return true;	//par défaut on part du principe que la valeur existe dans la base
	}					//pour ne pas insérer une valeur déjà existante
	
	
	public static void insert(String nameFile, int numFeuille) throws IOException {
		
		ArrayList<ArrayList<Object>> tab = tableau(nameFile, numFeuille);
		
		String table = upperCaseFirst(readFeuilleExcel(nameFile, numFeuille).getSheetName());
		
		String requete = "INSERT INTO " + table + " VALUES (";
		
		int cpt = 1;
		
		while (cpt < tab.get(0).size()){
			
			requete += "?,";
			cpt++;
		}
		
		requete += "?)";
		
		try {
			int lignesBase = nbLignesTable(nameFile, numFeuille);
			
			if (tab.size() - lignesBase > 0) {
				
				for (int i = lignesBase; i < tab.size(); i++) {
					
					PreparedStatement psm = conn.prepareStatement(requete);

					for (int j = 0; j < tab.get(i).size(); j++) {
						if (tab.get(i).get(j).getClass() == Integer.class) {
							psm.setInt(j+1, (int)tab.get(i).get(j));
						}
						else if ((String)tab.get(i).get(j) != "null")
							psm.setString(j+1, (String)tab.get(i).get(j));
					}
					psm.executeUpdate();
				}
				ln(1);
				System.out.println(tab.size() - lignesBase + " nouvelles lignes inserees dans la table " + table);
			}
			else
				System.out.println("Toutes les données de la table sont déjà présente dans la base");
		}
		catch (SQLException e) {
			e.printStackTrace();
		}
	}
	
	
	@SuppressWarnings({ "resource", "rawtypes" })
	public static void insertAll(String nameFile) throws IOException {
		
		InputStream input = new FileInputStream("src/" + nameFile + ".xls");
		
		POIFSFileSystem fs = new POIFSFileSystem(input);
		
		HSSFWorkbook wb = new HSSFWorkbook(fs);
		
		for (int i = nbFeuilles(NAME_FILE)-1; i >= 0; i--) {
			
			Iterator lignes = wb.getSheetAt(i).rowIterator();
			
			if(lignes.hasNext())
				insert(nameFile, i);			
		}		
	}
	
	
	
// ----------------------------------- STATISTIQUES --------------------------------------------//
	
	
	public static String getNomById(String mail) throws SQLException {
		
		ResultSet rs = result("SELECT i.nom, i.prenom FROM Individu i INNER JOIN Emprunteur e ON"
							  + " i.numIndividu = e.numIndividu WHERE e.mail = '" + mail + "'", conn, 0);
		if (rs.next()) {
			return upperCaseFirst(rs.getString("prenom")) + " " + upperCaseFirst(rs.getString("nom"));
		}
		rs.close();
		return null;
	}
	
	public static String getTitreByNum(int num, String attribut, String table) throws SQLException {
		String numero = "num" + table;
		PreparedStatement psm = conn.prepareStatement("SELECT " + attribut + " FROM " + table + " WHERE " + numero + " = " + num);		
		ResultSet rs = psm.executeQuery();
		
		while (rs.next()) {
			return rs.getString(1);
		}
		rs.close();
		return null;
	}
	
	
	public static int getNbEmprunt(String mail) throws SQLException {
		
		PreparedStatement psmL = conn.prepareStatement("SELECT COUNT(*) AS 'nb' FROM EmpruntLivre WHERE mail = ?");
		PreparedStatement psmF = conn.prepareStatement("SELECT COUNT(*) AS 'nb' FROM EmpruntFilm WHERE mail = ?");
		PreparedStatement psmA = conn.prepareStatement("SELECT COUNT(*) AS 'nb' FROM EmpruntAlbum WHERE mail = ?");
		psmL.setString(1, mail);
		psmF.setString(1, mail);
		psmA.setString(1, mail);
		
		ResultSet rsL = psmL.executeQuery();
		ResultSet rsF = psmF.executeQuery();
		ResultSet rsA = psmA.executeQuery();
		
		int nb = 0;
		
		if (rsL.next()) {
			nb += rsL.getInt("nb");
		}
		if(rsF.next()) {
			nb += rsF.getInt("nb");
		}
		if(rsA.next()) {
			nb += rsA.getInt("nb");
		}
		rsF.close(); rsL.close(); rsA.close();
		return nb;
	}
	
	public static void empruntsEnCours(String mail) throws SQLException {
		
		String reqF = "SELECT f.titreFilm, ef.dateEmprunt, ef.dateRetour "
				+ "FROM RetourFilm rf "
				+ "INNER JOIN EmpruntFilm ef ON rf.numExemplaire = ef.numExemplaire AND rf.mail = ef.mail "
				+ "INNER JOIN ExemplaireFilm exf ON ef.numExemplaire = exf.numExemplaire "
				+ "INNER JOIN Film f ON exf.numFilm = f.numFilm "
				+ "WHERE rf.mail = ? "
				+ "AND rf.dateRendu IS NULL";
		
		String reqA = "SELECT a.titreAlbum, ea.dateEmprunt, ea.dateRetour "
				+ "FROM RetourAlbum ra "
				+ "INNER JOIN EmpruntAlbum ea ON ra.numExemplaire = ea.numExemplaire AND ra.mail = ea.mail "
				+ "INNER JOIN ExemplaireAlbum exa ON ea.numExemplaire = exa.numExemplaire "
				+ "INNER JOIN Album a ON exa.numAlbum = a.numAlbum "
				+ "WHERE ra.mail = ? "
				+ "AND ra.dateRendu IS NULL";
		
		String reqL = "SELECT l.titreLivre, el.dateEmprunt, el.dateRetour "
				+ "FROM RetourLivre rl "
				+ "INNER JOIN EmpruntLivre el ON rl.numExemplaire = el.numExemplaire AND rl.mail = el.mail "
				+ "INNER JOIN ExemplaireLivre exl ON el.numExemplaire = exl.numExemplaire "
				+ "INNER JOIN Livre l ON exl.numLivre = l.numLivre "
				+ "WHERE rl.mail = ? "
				+ "AND rl.dateRendu IS NULL";
		
		PreparedStatement psmF = conn.prepareStatement(reqF);
		psmF.setString(1, mail);
		PreparedStatement psmA = conn.prepareStatement(reqA);
		psmA.setString(1, mail);
		PreparedStatement psmL = conn.prepareStatement(reqL);
		psmL.setString(1, mail);
		ResultSet rsL = psmL.executeQuery();
		ResultSet rsF = psmF.executeQuery();
		ResultSet rsA = psmA.executeQuery();
		
		System.out.println(" En cours d'emprunt (" + getNomById(mail) + ") : ");

		ln(1);
		
		while (rsF.next()) {
			System.out.println(" (Film) - Titre : " + rsF.getString("titreFilm") + " | Date d'emprunt : " + rsF.getString("dateEmprunt") + " | Date limite de retour : " + rsF.getString("dateRetour"));
		}
		while (rsL.next()) {
			System.out.println(" (Livre) - Titre : " + rsL.getString("titreLivre") + " | Date d'emprunt : " + rsL.getString("dateEmprunt") + " | Date limite de retour : " + rsL.getString("dateRetour"));
		}
		while (rsA.next()) {
			System.out.println(" (Album) - Titre : " + rsA.getString("titreAlbum") + " | Date d'emprunt : " + rsA.getString("dateEmprunt") + " | Date limite de retour : " + rsA.getString("dateRetour"));
		}
		rsF.close(); rsL.close(); rsA.close();
		
		ln(1);
	}
	
	
	public static void albumPlusEmprunte() throws SQLException {
		
		String req = "UPDATE _Declencheur SET id = '0'";
		Statement reset = conn.createStatement();
		reset.execute(req);
		String req1 = "UPDATE _Declencheur SET id = '1'";
		Statement st = conn.createStatement();
		st.execute(req1);
		
		try {
			CallableStatement cst = conn.prepareCall("{ call albumEmprunte() }");
			cst.execute();
			ResultSet rs = cst.getResultSet();
			
			if (rs.next()) {
				System.out.println(" - Titre : " + rs.getString("titreAlbum") + " | Nombre d'emprunts : " + rs.getInt("nbEmprunts"));
			}
			cst.close();
		}
		catch (Exception e) {
			ResultSet rs = result("SELECT AlbumLePlusEmprunte FROM _Statistiques", conn, 0);
			if (rs.next()) {
				System.out.println(" - Titre : " + rs.getString("AlbumLePlusEmprunte"));
			}
		}
		
	}
	
	
	public static void livrePlusEmprunte() throws SQLException {
		
		String req = "UPDATE _Declencheur SET id = '0'";
		Statement reset = conn.createStatement();
		reset.execute(req);
		String req1 = "UPDATE _Declencheur SET id = '2'";
		Statement st = conn.createStatement();
		st.execute(req1);
		
		try {
			CallableStatement cst = conn.prepareCall("{ call livreEmprunte() }");
			cst.execute();
			ResultSet rs = cst.getResultSet();
			
			if (rs.next()) {
				System.out.println(" - Titre : " + rs.getString("titreLivre") + " | Nombre d'emprunts : " + rs.getInt("nbEmprunts"));
			}
			cst.close();	
		}
		catch (Exception e) {
			ResultSet rs = result("SELECT LivreLePlusEmprunte FROM _Statistiques", conn, 0);
			if (rs.next()) {
				System.out.println(" - Titre : " + rs.getString("LivreLePlusEmprunte"));
			}
		}
	
	}
	
	public static void filmPlusEmprunte() throws SQLException {
		
		String req = "UPDATE _Declencheur SET id = '0'";
		Statement reset = conn.createStatement();
		reset.execute(req);
		String req1 = "UPDATE _Declencheur SET id = '3'";
		Statement st = conn.createStatement();
		st.execute(req1);
		
		try {
			CallableStatement cst = conn.prepareCall("{ call filmEmprunte() }");
			cst.execute();
			ResultSet rs = cst.getResultSet();
			
			if (rs.next()) {
				System.out.println(" - Titre : " + rs.getString("titreFilm") + " | Nombre d'emprunts : " + rs.getInt("nbEmprunts"));
			}
			cst.close();
		}
		catch (Exception e) {
			ResultSet rs = result("SELECT FilmLePlusEmprunte FROM _Statistiques", conn, 0);
			if (rs.next()) {
				System.out.println(" - Titre : " + rs.getString("FilmLePlusEmprunte"));
			}
		}
		
	}
	
	
	public static void objetPlusEmprunte() throws SQLException {
		try {
			CallableStatement cstF = conn.prepareCall("{ call filmEmprunte() }");
			CallableStatement cstL = conn.prepareCall("{ call livreEmprunte() }");
			CallableStatement cstA = conn.prepareCall("{ call albumEmprunte() }");
			
			cstF.execute();
			cstL.execute();
			cstA.execute();
			
			ResultSet rsF = cstF.getResultSet();
			ResultSet rsL = cstL.getResultSet();
			ResultSet rsA = cstA.getResultSet();
			
			int f = 0, l = 0, a = 0;
			String sf = "", sl = "", sa= "";
			
			if (rsF.next()) {
				f = rsF.getInt("nbEmprunts");
				sf = rsF.getString("titreFilm");
			}
			
			if (rsL.next()) {
				l = rsL.getInt("nbEmprunts");
				sl = rsL.getString("titreLivre");
			}
			
			if (rsA.next()) {
				a = rsA.getInt("nbEmprunts");
				sa = rsA.getString("titreAlbum");
			}
			
			System.out.println(" L'element le plus emprunte : ");
			ln(1);
			
			if (f > l) {
				if (f > a)		
					System.out.println(" (Film) - Titre : " + sf + " | Nombre d'emprunts : " + f);
				else if (l > a)
					System.out.println(" (Livre) - Titre : " + sl + " | Nombre d'emprunts : " + l);
				else
					System.out.println(" (Album) - Titre : " + sa + " | Nombre d'emprunts : " + a);
			}
			else if (l > a)
				System.out.println(" (Livre) - Titre : " + sl + " | Nombre d'emprunts : " + l);
			else
				System.out.println(" (Album) - Titre : " + sa + " | Nombre d'emprunts : " + a);		
		
			cstL.close(); cstA.close(); cstF.close();
			rsF.close(); rsL.close(); rsA.close();
		}
		catch (Exception e) {
			System.out.println("Problème d'accès aux CallableStatement...");
		}
		
	}
	
	
	public static void historiqueEmprunt(String mail) throws SQLException {
		CallableStatement csmL = conn.prepareCall("{ call historiqueEmpruntL(?) }");
		CallableStatement csmF = conn.prepareCall("{ call historiqueEmpruntF(?) }");
		CallableStatement csmA = conn.prepareCall("{ call historiqueEmpruntA(?) }");
		
		csmL.setString(1, mail);
		csmF.setString(1, mail);
		csmA.setString(1, mail);
		
		csmL.execute();
		csmF.execute();
		csmA.execute();
		
		ResultSet rsL = csmL.getResultSet();
		ResultSet rsF = csmF.getResultSet();
		ResultSet rsA = csmA.getResultSet();
		
		System.out.println(" Historique d'emprunts (" + getNomById(mail) + ") : ");

		ln(1);
		while (rsL.next()) {
			if(rsL.getString("dateRendu").equals("null")) {
				System.out.println(" (Livre) - Numero d'exemplaire : " + rsL.getInt("numExemplaire") 
								   + "\n	 - Titre : " + rsL.getString("titreLivre") 
								   + "\n	 - Date d'emprunt : " + rsL.getString("dateEmprunt") 
								   + "\n	 - Livre non rendu !");
			}
			else {
				System.out.println(" (Livre) - Numero d'exemplaire : " + rsL.getInt("numExemplaire") 
							       + "\n	 - Titre : " + rsL.getString("titreLivre") 
							       + "\n	 - Date d'emprunt : " + rsL.getString("dateEmprunt") 
							       + "\n	 - Date de rendu : " + rsL.getString("dateRendu"));
			}
			ln(1);
		}
		
		while (rsF.next()) {
			if(rsF.getString("dateRendu").equals("null")) {
				System.out.println(" (Film)  - Numero d'exemplaire : " + rsF.getInt("numExemplaire")
								   + "\n	 - Titre : " + rsF.getString("titreFilm") 
								   + "\n	 - Date d'emprunt : " + rsF.getString("dateEmprunt")
								   + "\n	 - Film non rendu !");
			}
			else {
				System.out.println(" (Film)  - Numero d'exemplaire : " + rsF.getInt("numExemplaire") 
								   + "\n	 - Titre : " + rsF.getString("titreFilm") 
								   + "\n	 - Date d'emprunt : " + rsF.getString("dateEmprunt") 
								   + "\n	 - Date de rendu : " + rsF.getString("dateRendu"));
			}
			ln(1);
		}
		
		while (rsA.next()) {
			if(rsA.getString("dateRendu").equals("null")) {
				System.out.println(" (Album) - Numero d'exemplaire : " + rsA.getInt("numExemplaire") 
								   + "\n	 - Titre : " + rsA.getString("titreAlbum") 
								   + "\n	 - Date d'emprunt : " + rsA.getString("dateEmprunt") 
								   + "\n	 - Album non rendu !");
			}
			else {
				System.out.println(" (Album) - Numero d'exemplaire : " + rsA.getInt("numExemplaire") 
								   + "\n	 - Titre : " + rsA.getString("titreAlbum") 
								   + "\n	 - Date d'emprunt : " + rsA.getString("dateEmprunt") 
								   + "\n	 - Date de rendu : " + rsA.getString("dateRendu"));
			}
			ln(1);
		}
		csmL.close(); csmA.close(); csmF.close();
		rsF.close(); rsL.close(); rsA.close();
		ln(1);
	}
	
	
	public static void grosEmprunteur() throws SQLException {
		PreparedStatement psm = conn.prepareStatement("SELECT mail FROM Emprunteur");
		ResultSet rs = psm.executeQuery();
		
		int max = 0;
		String mail = "";
		while (rs.next()){
			String mail2 = rs.getString("mail");
			if (max < getNbEmprunt(rs.getString("mail"))) {
				max = getNbEmprunt(rs.getString("mail"));
				mail = mail2;
			}
		}
		System.out.println(" Le ou la plus gros(se) emprunteur(euse) de la bibliotheque est " + getNomById(mail) + " avec " + max + " emprunts au total");
		rs.close();
	}
	
	
	public static void grosEmprunteurAlbum() throws SQLException {
		
		String req = "UPDATE _Declencheur SET id = '0'";
		Statement reset = conn.createStatement();
		reset.execute(req);
		String req1 = "UPDATE _Declencheur SET id = '6'";
		Statement st = conn.createStatement();
		st.execute(req1);
		
		try {
			CallableStatement csmA = conn.prepareCall("{ call emprunteurPopA() }");
			csmA.execute();
			ResultSet rsA = csmA.getResultSet();
			
			if (rsA.next()) {
				System.out.println(" Le ou la plus gros(se) emprunteur(euse) d'albums est " + getNomById(rsA.getString("mail")) + " avec " + rsA.getInt("nbEmprunts") + " albums empruntes");
			}
			csmA.close();
		}
		catch(Exception e) {
			e.printStackTrace();
			ResultSet rs = result("SELECT PlusGrosEmprunteurAlbum FROM _Statistiques", conn, 0);
			if (rs.next()) {
				System.out.println(" - Plus gros emprunteur d'albums : " + getNomById(rs.getString("PlusGrosEmprunteurAlbum")));
			}
		}

	}
	
	public static void grosEmprunteurFilm() throws SQLException {
		
		String req = "UPDATE _Declencheur SET id = '0'";
		Statement reset = conn.createStatement();
		reset.execute(req);
		String req1 = "UPDATE _Declencheur SET id = '5'";
		Statement st = conn.createStatement();
		st.execute(req1);
		
		try {
			CallableStatement csmF = conn.prepareCall("{ call emprunteurPopF() }");
			csmF.execute();
			ResultSet rsF = csmF.getResultSet();
			
			if (rsF.next()) {
				System.out.println(" Le ou la plus gros(se) emprunteur(euse) de films est " + getNomById(rsF.getString("mail")) + " avec " + rsF.getInt("nbEmprunts") + " films empruntes");
			}
			csmF.close();
		}
		catch(Exception e) {
			ResultSet rs = result("SELECT PlusGrosEmprunteurFilm FROM _Statistiques", conn, 0);
			if (rs.next()) {
				System.out.println(" - Plus gros emprunteur de films : " + getNomById(rs.getString("PlusGrosEmprunteurFilm")));
			}
		}
		

	}
	
	public static void grosEmprunteurLivre() throws SQLException {
		
		String req = "UPDATE _Declencheur SET id = '0'";
		Statement reset = conn.createStatement();
		reset.execute(req);
		String req1 = "UPDATE _Declencheur SET id = '4'";
		Statement st = conn.createStatement();
		st.execute(req1);
		
		try {
			CallableStatement csmL = conn.prepareCall("{ call emprunteurPopL() }");
			csmL.execute();
			ResultSet rsL = csmL.getResultSet();
			
			if (rsL.next()) {
				System.out.println(" Le ou la plus gros(se) emprunteur(euse) de livres est " + getNomById(rsL.getString("mail")) + " avec " + rsL.getInt("nbEmprunts") + " livres empruntes");
			}
			csmL.close();
		}
		catch(Exception e) {
			ResultSet rs = result("SELECT PlusGrosEmprunteurLivre FROM _Statistiques", conn, 0);
			if (rs.next()) {
				System.out.println(" - Plus gros emprunteur de livres : " + getNomById(rs.getString("PlusGrosEmprunteurLivre")));
			}
		}
		
	}
	
	
	public static void nbExEmpruntableLivre(int numLivre) throws SQLException {
		CallableStatement cstm = conn.prepareCall("{ ? = call nbExEmpruntableL(?) }");
		cstm.registerOutParameter(1, java.sql.Types.INTEGER);
		cstm.setInt(2, numLivre);
		cstm.execute();
		
		System.out.println(" Il reste " + cstm.getInt(1) + " exemplaire de " + getTitreByNum(numLivre, "titreLivre", "Livre"));
	}
	
	
	public static void nbExEmpruntableAlbum(int numAlbum) throws SQLException {
		CallableStatement cstm = conn.prepareCall("{ ? = call nbExEmpruntableA(?) }");
		cstm.registerOutParameter(1, java.sql.Types.INTEGER);
		cstm.setInt(2, numAlbum);
		cstm.execute();
		
		System.out.println(" Il reste " + cstm.getInt(1) + " exemplaire de " + getTitreByNum(numAlbum, "titreAlbum", "Album"));
	}
	
	
	public static void nbExEmpruntableFilm(int numFilm) throws SQLException {
		CallableStatement cstm = conn.prepareCall("{ ? = call nbExEmpruntableF(?) }");
		cstm.registerOutParameter(1, java.sql.Types.INTEGER);
		cstm.setInt(2, numFilm);
		cstm.execute();
		
		System.out.println(" Il reste " + cstm.getInt(1) + " exemplaire de " + getTitreByNum(numFilm, "titreFilm", "Film"));
	}
	
// --------------------------------------- MAIN ------------------------------------------------//
	
	
	public static void main(String[] arg) throws SQLException, IOException {		
		
		Scanner sc = new Scanner(System.in);
		
		int fin = 1;
		
		while (fin != 0) {
			ln(40);
			System.out.println("________________________________________________________________________________");
			System.out.println("				      MENU");
			System.out.println("________________________________________________________________________________");
		
			ln(2);
			
			System.out.println(" 1 - Afficher les donnees");
			ln(1);
			System.out.println(" 2 - Ajouter des donnees");
			ln(1);
			System.out.println(" 3 - Supprimer des donnees");
			ln(1);
			System.out.println(" 4 - Consulter les statistiques");
			ln(1);
			System.out.print("   ->"); int choix = gestionScannerInt(sc); ln(1);
			
			while (choix != 1 && choix != 2 && choix != 3 && choix != 4) {
				System.out.println(" Choisir un nombre entre 1, 2, 3 ou 4 : ");
				System.out.print("   ->"); choix = gestionScannerInt(sc); ln(1);
			}
			
			ln(55);
			
			if (choix == 1) {
				
				System.out.println("________________________________________________________________________________");
				System.out.println("				AFFICHER LES DONNEES");
				System.out.println("________________________________________________________________________________");
				ln(2);
				
				int continuer = 1;
				while (continuer == 1) {
					System.out.println("Choisissez la table a afficher : ");ln(1);
					
					System.out.println(" 0 - Acteur"); 
					System.out.println(" 1 - Artiste");
					System.out.println(" 2 - Auteur");
					System.out.println(" 3 - Edition");
					System.out.println(" 4 - EmpruntAlbum");
					System.out.println(" 5 - EmpruntFilm");
					System.out.println(" 6 - EmpruntLivre");
					System.out.println(" 7 - GenreAlbum");
					System.out.println(" 8 - GenreFilm");
					System.out.println(" 9 - GenreMetrage");
					System.out.println(" 10 - GenreMusique");
					System.out.println(" 11 - ThemeLivre");
					System.out.println(" 12 - RetourAlbum");
					System.out.println(" 13 - RetourFilm");
					System.out.println(" 14 - RetourLivre");
					System.out.println(" 15 - ExemplaireAlbum");
					System.out.println(" 16 - ExemplaireFilm");
					System.out.println(" 17 - ExemplaireLivre");
					System.out.println(" 18 - Editeur");
					System.out.println(" 19 - Film");
					System.out.println(" 20 - Emprunteur");
					System.out.println(" 21 - Categorie");
					System.out.println(" 22 - Individu");
					System.out.println(" 23 - Livre");
					System.out.println(" 24 - Type");
					System.out.println(" 25 - Saga");
					System.out.println(" 26 - Theme");
					System.out.println(" 27 - Album");
					System.out.println(" 28 - Carte"); ln(1);
					
					System.out.print(" ->"); int sheet = gestionScannerInt(sc);
					
					while (sheet < 1 || sheet >29) {
						System.out.println(" Choisissez un nombre parmi la liste ci-dessus");
						System.out.print(" ->"); sheet = gestionScannerInt(sc); ln(1);
					}
					
					ArrayList<ArrayList<Object>> fullList = tableau(NAME_FILE, sheet);
					
					System.out.println(" -------- " + nomFeuille(sheet).toUpperCase() + " --------");
					ln(1);					
					affiche(fullList);
					
					ln(2);
					
					System.out.println(" Voulez-vous afficher une nouvelle table ?");ln(1);
					System.out.println(" 1 - oui");
					System.out.println(" 0 - non");
					System.out.print(" ->"); continuer = gestionScannerInt(sc); ln(1);
					
					while (sheet < 0 && sheet > 1) {
						System.out.println(" 1 pour reafficher une table, 0 sinon");
						System.out.print(" ->"); continuer = sc.nextInt(); ln(1);
					}
				}
			}
			
			ln(2);
			
// ----------------------------------- INSERTION DES DONNEES --------------------------------------------//
				
			if (choix == 2) {
				
				System.out.println("________________________________________________________________________________");
				System.out.println("				AJOUTER DES DONNEES");
				System.out.println("________________________________________________________________________________");
			
				ln(2);
				
				System.out.println(" 1 - ajouter tout le fichier");
				System.out.println(" 0 - ne rien faire");
				System.out.print(" -> "); int choixAjout = gestionScannerInt(sc); ln(1);
				
				
				while (choixAjout < 0 || choixAjout > 1) {
					System.out.println(" 1 pour ajouter tout le fichier, 0 pour ne rien faire");
					System.out.print(" -> "); choixAjout = gestionScannerInt(sc); ln(1);
				}
				
				if (choixAjout == 1) {
					
					System.out.println(" Etes-vous sur de vouloir insert tout le fichier ?"); ln(1);
					System.out.println(" 1 - oui");
					System.out.println(" 0 - non");
					
					System.out.print("    ->"); choixAjout = gestionScannerInt(sc); ln(1);
					
					while (choixAjout < 0 || choixAjout > 1) {
						System.out.println(" Choisir 1 pour insert, 0 sinon");
						System.out.print(" ->"); choixAjout = gestionScannerInt(sc); ln(1);
					}
					if (choixAjout == 1) {
						insertAll(NAME_FILE);
					}
				}
			}
			
			
// ----------------------------------- SUPPRESSION DES DONNEES --------------------------------------------//
			
			
			else if (choix == 3){
				
				System.out.println("________________________________________________________________________________");
				System.out.println("				SUPPRESSION DES DONNEES");
				System.out.println("________________________________________________________________________________");
				
				ln(2);

				System.out.println(" - 1 : supprimer les donnees de toutes les tables");
				System.out.println(" - 0 : ne rien faire");
				ln(1);
				System.out.print("    ->"); int choixSupp = gestionScannerInt(sc); ln(1);
				
				while (choixSupp < 0 || choixSupp > 1) {
					System.out.println(" 1 pour supprimer toutes les donees ou 0 pour ne rien faire");
					System.out.print("    ->"); choixSupp = gestionScannerInt(sc); ln(1);
				}
				
				if (choixSupp == 1) {
					ln(1);
					System.out.println(" Etes-vous sur de vouloir supprimer les donnees de toutes les tables ?");
					System.out.println(" 1 - oui");
					System.out.println(" 0 - non");
					
					System.out.print(" ->"); choix = gestionScannerInt(sc); ln(1);
					
					while (choix < 0 || choix > 1) {
						System.out.println(" Choisir 1 pour tout supprimer, 0 sinon");
						System.out.print(" ->"); choix = gestionScannerInt(sc); ln(2);
					}
					if (choix == 1) {
						deleteAll(NAME_FILE);
					}
				}				
			}
			
			
// ----------------------------------- STATISTIQUES --------------------------------------------//
			
			
			else if(choix == 4) {
				
				System.out.println(" 1 - Afficher les emprunts en cours d'un emprunteur donne"); //DONE
				ln(1);
				System.out.println(" 2 - Afficher l'album le plus emprunte"); //DONE
				ln(1);
				System.out.println(" 3 - Afficher le livre le plus emprunte");//DONE
				ln(1);
				System.out.println(" 4 - Afficher le film le plus emprunte");//DONE
				ln(1);
				System.out.println(" 5 - Afficher l'element le plus emprunte");//DONE
				ln(1);
				System.out.println(" 6 - Afficher l'historique d'emprunt d'un emprunteur donne");//DONE
				ln(1);
				System.out.println(" 7 - Afficher le plus gros emprunteur global de la mediatheque");
				ln(1);
				System.out.println(" 8 - Afficher le plus gros emprunteur de livres de la mediatheque");
				ln(1);
				System.out.println(" 9 - Afficher le plus gros emprunteur de films de la mediatheque");
				ln(1);
				System.out.println(" 10 - Afficher le plus gros emprunteur d'albums de la mediatheque");
				ln(1);
				System.out.println(" 11 - Afficher le nombre d'exemplaires empruntables d'un livre donne");
				ln(1);
				System.out.println(" 12 - Afficher le nombre d'exemplaires empruntables d'un film donne");
				ln(1);
				System.out.println(" 13 - Afficher le nombre d'exemplaires empruntables d'un album donne");
				
				System.out.print("   ->"); int choixStat = gestionScannerInt(sc); ln(1);
				
				while (choixStat < 1 || choixStat > 13) {
					System.out.println(" Choisir un nombre entre 1 et 13 : "); ln(1);
					System.out.print("   ->"); choixStat = gestionScannerInt(sc); ln(1);
				}
				ln(1);
				
				if (choixStat == 1) {
					
					System.out.println(" Choisissez le mail de l'emprunteur dont vous voulez connaitre les emprunts en cours :");
					System.out.print(" ->"); String mail = gestionScannerString(sc); ln(1);
					
					while (!present(mail, "mail", "Emprunteur")) {
						System.out.println("L'mail '" + mail + "' n'existe pas dans la base de donnees");
						System.out.println("Rentrez un mail valide : ");
						System.out.print(" ->"); mail = gestionScannerString(sc); ln(1);
					}
					
					ln(2);
					empruntsEnCours(mail);
					
				}
				
				if (choixStat == 2) {
					albumPlusEmprunte();					
				}
				
				if (choixStat == 3) {
					livrePlusEmprunte();
				}
				
				if (choixStat == 4) {
					filmPlusEmprunte();
				}
				
				if (choixStat == 5) {
					objetPlusEmprunte();
				}
				
				if (choixStat == 6) {
					System.out.println(" Choisissez le mail de l'emprunteur dont vous voulez connaitre l'historique d'emprunt :");
					System.out.print(" ->"); String email = gestionScannerString(sc); ln(1);
					
					while (!present(email, "mail", "Emprunteur")) {
						System.out.println(" Le mail '" + email + "' n'existe pas dans la base de donnees");
						System.out.println(" Rentrez un mail valide : ");
						System.out.print(" ->"); email = gestionScannerString(sc); ln(1);
					}
					
					ln(2);					
					historiqueEmprunt(email);
				}
				
				if (choixStat == 7) {
					grosEmprunteur();
				}
				
				if (choixStat == 8) {
					grosEmprunteurLivre();
				}
				
				if (choixStat == 9) {
					grosEmprunteurFilm();
				}
				
				if (choixStat == 10) {
					grosEmprunteurAlbum();
				}	
				
				if (choixStat == 11) {
					System.out.println(" Choisissez le numero du livre dont vous voulez connaitre le nombre d'exemplaires restants :");
					System.out.print(" ->"); int numero = gestionScannerInt(sc); ln(1);
					
					while (!present(numero, "numLivre", "Livre")) {
						System.out.println(" Le livre numero '" + numero + "' n'existe pas dans la base de donnees");
						System.out.println(" Rentrez un numero de livre valide : ");
						System.out.print(" ->"); numero = gestionScannerInt(sc); ln(1);
					}
					ln(1);
					nbExEmpruntableLivre(numero);
				}
				
				if (choixStat == 12) {
					System.out.println(" Choisissez le numero du film dont vous voulez connaitre le nombre d'exemplaires restants :");
					System.out.print(" ->"); int numero = gestionScannerInt(sc); ln(1);
					
					while (!present(numero, "numFilm", "Film")) {
						System.out.println(" Le film numero '" + numero + "' n'existe pas dans la base de donnees");
						System.out.println(" Rentrez un numero de film valide : ");
						System.out.print(" ->"); numero = gestionScannerInt(sc); ln(1);
					}
					ln(1);
					nbExEmpruntableFilm(numero);
				}
				
				if (choixStat == 13) {
					System.out.println(" Choisissez le numero de l'album dont vous voulez connaitre le nombre d'exemplaires restants :");
					System.out.print(" ->"); int numero = gestionScannerInt(sc); ln(1);
					
					while (!present(numero, "numAlbum", "Album")) {
						System.out.println(" L'album numero '" + numero + "' n'existe pas dans la base de donnees");
						System.out.println(" Rentrez un numero d'album valide : ");
						System.out.print(" ->"); numero = gestionScannerInt(sc); ln(1);
					}
					ln(1);
					nbExEmpruntableAlbum(numero);
				}
			}
			
			ln(5);
			
			System.out.println(" 1 - Revenir au menu");
			System.out.println(" 0 - Quitter"); ln(1);
			
			System.out.print("    ->"); fin = gestionScannerInt(sc); ln(1);
			
		}	
		
		sc.close();
		conn.close();
		
		System.out.println(" Connexion fermee !");
	}	
}
