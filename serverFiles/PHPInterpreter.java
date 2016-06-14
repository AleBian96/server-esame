package alebian;
import java.io.*;
import java.util.UUID;

public class PHPInterpreter{
	String wrapper = "wrap.php";
	boolean DEV = false;

	public PHPInterpreter(boolean DEV){
		this.DEV = DEV;
	}

	public File eval(String path,String GET, String POST, String COOKIE) throws Exception {
		GET = GET=="" ? "''" : GET;
		POST = POST=="" ? "''" : POST;
		COOKIE = COOKIE==null ? "''" : COOKIE;

		GET = GET.replace(" ","%20");
		POST = POST.replace(" ","%20");
		COOKIE = COOKIE.replace(" ","%20");

		String command = "php "+wrapper+" "+path+" "+GET+" "+POST+" "+COOKIE;
		Process p = Runtime.getRuntime().exec(command);
		BufferedReader str = new BufferedReader(new InputStreamReader(p.getInputStream()));
		BufferedReader err = new BufferedReader(new InputStreamReader(p.getErrorStream()));

		p.waitFor();

		String line = "",code = "";
		if(DEV)while((line = err.readLine()) != null)
			code += line+"\n";

		if(code.equals(""))while((line = str.readLine()) != null)
			code += line+"\n";

		File T = File.createTempFile(randomUUID(),".tmp");
		Writer w = new BufferedWriter(new FileWriter(T));
		w.append(code);
		w.flush();

		return T;
	}
	public static String randomUUID(){
		return UUID.randomUUID().toString().replaceAll("-","");
	}
}
