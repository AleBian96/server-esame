package alebian;
import java.io.*;
import java.util.Random;
import java.security.SecureRandom;

public class PHPInterpreter{
	String wrapper = "wrap.php";
	char[] charSet = "ABCDEFGHIJKLMNOPQRSTUVZ0123456789".toCharArray();
	boolean DEV = false;

	public PHPInterpreter(boolean DEV){
		this.DEV = DEV;
	}

	public File eval(String path,String GET, String POST) throws Exception {
		GET = GET=="" ? "''" : GET;
		POST = POST=="" ? "''" : POST;
		GET = GET.replace(" ","%20");
		POST = POST.replace(" ","%20");
		String command = "php "+wrapper+" "+path+" "+GET+" "+POST;
		Process p = Runtime.getRuntime().exec(command);
		BufferedReader str = new BufferedReader(new InputStreamReader(p.getInputStream()));
		BufferedReader err = new BufferedReader(new InputStreamReader(p.getErrorStream()));

		p.waitFor();

		String line = "",code = "";boolean died=false;
		if(DEV)while((line = err.readLine()) != null)
			{code += line+"\n";died=true;}

		if(died)code+="die();";

		while((line = str.readLine()) != null)
			code += line+"\n";

		File T = File.createTempFile(getRandomString(charSet,8),".tmp");
		Writer w = new BufferedWriter(new FileWriter(T));
		w.append(code);
		w.flush();

		return T;
	}
	private String getRandomString(char[] charSet,int len){
		Random gen = new SecureRandom();

		char[] res = new char[len];
		for(int i = 0;i<len;i++){
			int rchar = gen.nextInt(charSet.length);
			res[i] = charSet[rchar];
		}
		return res.toString();
	}
}
