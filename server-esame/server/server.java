package alebian;
import alebian.messageHandler;
import alebian.PHPInterpreter;
import java.io.*;
import java.net.*;
import java.security.SecureRandom;
import java.nio.ByteBuffer;

public class server{
	public static void main(String args[]){
		try{
			for(int i=0;i<8;i++)args[i].charAt(0);
		}catch(Exception e){
			System.out.println("\u001B[31m[ERROR]: \u001B[0m"+"Usage: server [domain_name][token][port][site_folder][site_index][DEV][DDNS][VERBOSE]");
			System.exit(1);
		}
		boolean VERBOSE = args[7].equals("true") ? true : false;
		if(args[6].equals("true")){
			if(VERBOSE)System.out.println("\u001B[31m[SERVER]: \u001B[0m"+"Starting DDNS");
			try{
				URL url = new URL("https://duckdns.org/update/"+args[0]+"/"+args[1]);
				String l = new BufferedReader(new InputStreamReader(url.openStream())).readLine();
				if(!l.equals("OK")){System.out.println("\u001B[31m[DDNS]: \u001B[0m"+"Connection error, check the token");System.exit(1);}
			}catch(Exception e){e.printStackTrace();}
		}

		ServerSocket sSocket;
		Socket s = null;
		int port = Integer.parseInt(args[2]);
		try{
			sSocket = new ServerSocket(port);
			if(VERBOSE)System.out.println("\u001B[31m[SERVER]: \u001B[0m"+"Server <"+args[0]+"> started");
			while(true){
				s = sSocket.accept();
				new serverThread(s,args[3],args[4],args[5],VERBOSE);
			}
		}
		catch(Exception e){
			System.out.println("\u001B[31m[ERROR]: \u001B[0m"+e);
		}
	}
}

class serverThread implements Runnable {

	String sitePath = null;
	String index = null;
	boolean VERBOSE = false;

	private Socket s = null;
	PrintWriter pw;
	messageHandler mh;
	PHPInterpreter PHP;

	public serverThread(Socket c,String sitePath,String index,String dev,boolean VERBOSE) throws Exception{
		this.sitePath = sitePath;
		this.index = index;
		this.VERBOSE = VERBOSE;
		s = c;
		Thread t = new Thread(this);
		pw = new PrintWriter(s.getOutputStream());
		mh = new messageHandler(s.getInputStream());
		t.start();
		PHP = new PHPInterpreter(dev.equals("true") ? true : false);
	}

	public void run(){
		try {
			while (true) {
				mh.handle();
				mh.Path = mh.Path.equals("/") ? index : mh.Path;
				DELIVER();
				if (mh.Connection.equalsIgnoreCase("Close")) return;
			}
		}catch(NullPointerException e){
			try{
				pw.close();
				s.close();
			}catch (Exception e1){}
			return;
		}catch(FileNotFoundException e){
if(VERBOSE)print("\u001B[31m"+e.getMessage()+"\u001B[0m");
			send("HTTP/1.1 404 File Not Found");
			send("");
		}catch(Exception e){
			if(VERBOSE)print("\u001B[31m"+e+"\u001B[0m");
			try{
				pw.close();
				s.close();
			}catch (Exception e1){}
			return;
		}
	}

//	SERVER METHODS
	private void print(String s){
		System.out.println("[ISSUE]: "+s);
	}
	private void send(String x){
		pw.println(x);pw.flush();
	}
	private void DELIVER() throws Exception {
		String name = sitePath+mh.Path;
		File x = name.endsWith(".php") ? PHP.eval(name,mh.Parameters,mh.body,mh.Cookie) : new File(name);
		FileInputStream file = new FileInputStream(x);
		DataOutputStream send = new DataOutputStream(s.getOutputStream());

		send("HTTP/1.1 200 OK");
		send("Content-Length: "+x.length());
		if(mh.Cookie==null){
			String sid = PHP.randomUUID();
			send("Set-Cookie: PHPSESSID="+sid);
		}
		send("");

		byte[] buffer = new byte[1024];
		int bytesRead;

		while ((bytesRead = file.read(buffer)) != -1)
			send.write(buffer, 0, bytesRead);

		send("");
		send.flush();
		file.close();
	}
}
