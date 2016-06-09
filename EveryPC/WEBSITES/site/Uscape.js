function Uscape(s){
	s = s.split("%5C").join("%5C%5C");
	s = s.split("%22").join("%5C%22");
	s = s.split("%24").join("%5C%24");
	s = s.split("%5Cn").join("%5C%5Cn");
	s = s.split("%5Ct").join("%5C%5Ct");
	s = unescape(s);
	s = s.split("%").join("%%");
	return s;
}
endline="^[nl]_"
