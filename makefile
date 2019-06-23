.DEFAULT_GOAL := clean-then-compile
in-file = ./stylesheets/all.scss
out-file = ./stylesheets/all.css

clean-then-compile: clean style
continuous: clean continuous-core

style:
	sass ${in-file} ${out-file}

clean:
	-rm ${out-file}*

continuous-core:
	sass --watch ${in-file}:${out-file}
