package alebian;
import java.io.*;

public class messageHandler{
	//Request
	public String Method;
	public String Path;
	public String Version;
	public String Parameters;

	//Headers
	public String Accept;
	public String AcceptCharset;
	public String AcceptEncoding;
	public String AcceptLanguage;
	public String AcceptDatetime;
	public String Authorization;
	public String CacheControl;
	public String Connection;
	public String Cookie;
	public String ContentLength;
	public String ContentMD5;
	public String ContentType;
	public String Date;
	public String Expect;
	public String From;
	public String Host;
	public String IfMatch;
	public String IfModifiedSince;
	public String IfNoneMatch;
	public String IfRange;
	public String IfUnmodifiedSince;
	public String MaxForwards;
	public String Origin;
	public String Pragma;
	public String ProxyAuthorization;
	public String Range;
	public String Refer;
	public String TE;
	public String UserAgent;
	public String Upgrade;
	public String Via;
	public String Warning;

	//Body
	public String body = "";

	BufferedReader in;
	public messageHandler(InputStream in){
		this.in = new BufferedReader(new InputStreamReader(in));
	}

	public void handle() throws Exception {
	this.handleHeader();
	if(this.Method.equals("POST"))handleBody();
	else if(this.Path.contains("?"))this.Parameters = this.Path.split("?")[1];
	this.Parameters = Parameters == null ? "" : Parameters;
	}

	private void handleHeader() throws Exception {
	this.reset();
	reqHandler(in.readLine());
	for(;!readHeader(););
	return;
	}
   public void handleBody() throws Exception {
		int x;
		String EOL = "\n";
		StringBuilder sb = new StringBuilder();
		for(int i=0; i<Integer.parseInt(ContentLength) && (x = in.read())!=-1 ;i++){
			sb.append((char)x);
		}
		body = sb.toString();

		body = body.replaceAll(EOL,"\n");
	}

	private void reset(){
		Method = null;
		Path = null;
		Version = null;
		Parameters = null;

		Accept = null;
		AcceptCharset = null;
		AcceptEncoding = null;
		AcceptLanguage = null;
		AcceptDatetime = null;
		Authorization = null;
		CacheControl = null;
		Connection = null;
		Cookie = null;
		ContentLength = null;
		ContentMD5 = null;
		ContentType = null;
		Date = null;
		Expect = null;
		From = null;
		Host = null;
		IfMatch = null;
		IfModifiedSince = null;
		IfNoneMatch = null;
		IfRange = null;
		IfUnmodifiedSince = null;
		MaxForwards = null;
		Origin = null;
		Pragma = null;
		ProxyAuthorization = null;
		Range = null;
		Refer = null;
		TE = null;
		UserAgent = null;
		Upgrade = null;
		Via = null;
		Warning = null;

		body = "";
	}
	private void reqHandler(String x){
		String[] p = x.split(" ");
		Method = p[0];
		Path = p[1];
		Version = p[2];
	}
	private boolean readHeader() throws Exception {
		String x;
		String h;
		while(!(x=in.readLine()).equals("")){
			if((h = retParam(x,"Accept"))!=null){Accept=h;continue;}
			if((h = retParam(x,"Accept-Charset"))!=null){AcceptCharset=h;continue;}
			if((h = retParam(x,"Accept-Encoding"))!=null){AcceptEncoding=h;continue;}
			if((h = retParam(x,"Accept-Language"))!=null){AcceptLanguage=h;continue;}
			if((h = retParam(x,"Accept-Datetime"))!=null){AcceptDatetime=h;continue;}
			if((h = retParam(x,"Authorization"))!=null){Authorization=h;continue;}
			if((h = retParam(x,"Cache-Control"))!=null){CacheControl=h;continue;}
			if((h = retParam(x,"Connection"))!=null){Connection=h;continue;}
			if((h = retParam(x,"Cookie"))!=null){Cookie=h;continue;}
			if((h = retParam(x,"Content-Length"))!=null){ContentLength=h;continue;}
			if((h = retParam(x,"Content-MD5"))!=null){ContentMD5=h;continue;}
			if((h = retParam(x,"Content-Type"))!=null){ContentType=h;continue;}
			if((h = retParam(x,"Date"))!=null){Expect=h;continue;}
			if((h = retParam(x,"From"))!=null){From=h;continue;}
			if((h = retParam(x,"Host"))!=null){Host=h;continue;}
			if((h = retParam(x,"If-Match"))!=null){IfMatch=h;continue;}
			if((h = retParam(x,"If-Modified-Since"))!=null){IfModifiedSince=h;continue;}
			if((h = retParam(x,"If-None-Match"))!=null){IfNoneMatch=h;continue;}
			if((h = retParam(x,"If-Range"))!=null){IfRange=h;continue;}
			if((h = retParam(x,"If-Unmodified-Since"))!=null){IfUnmodifiedSince=h;continue;}
			if((h = retParam(x,"Max-Forwards"))!=null){MaxForwards=h;continue;}
			if((h = retParam(x,"Origin"))!=null){Origin=h;continue;}
			if((h = retParam(x,"Pragma"))!=null){Pragma=h;continue;}
			if((h = retParam(x,"Proxy-Authorization"))!=null){ProxyAuthorization=h;continue;}
			if((h = retParam(x,"Range"))!=null){Range=h;continue;}
			if((h = retParam(x,"Refer"))!=null){Refer=h;continue;}
			if((h = retParam(x,"TE"))!=null){TE=h;continue;}
			if((h = retParam(x,"UserAgent"))!=null){UserAgent=h;continue;}
			if((h = retParam(x,"Upgrade"))!=null){Upgrade=h;continue;}
			if((h = retParam(x,"Via"))!=null){Via=h;continue;}
			if((h = retParam(x,"Warning"))!=null){Warning=h;continue;}

		}
		return true;
	}

	private String retParam(String x, String p){
		if(x.length()>p.length()){
			if(x.startsWith(p)){
				String s = x.replace(" ","").replace(":","");
				int spaces = x.length()-s.length();
				String r = x.substring(p.length()+spaces);
				return r;
			}
		}
		return null;
	}

}
