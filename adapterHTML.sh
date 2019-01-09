#!/bin/bash

let BEGINLINE='0'
let LASTLINE='0'
FILTRO='<div class="dvContenido'
APERTURADIV='<div '
CIERRADIV='</div>'
#FILTRO='<blockquote>'
#APERTURADIV='<blockquote>'
#CIERRADIV='</blockquote>'
FILTRO='<div id="pie">'
APERTURADIV='<div '
CIERRADIV='</div>'
EXTENSION="*.htm*"
IFS=$'\n'
PATH_ACTUAL=$( pwd )
PLANTILLA='aqui la ruta de tu plantilla (puede ser html o php)'

## Nos devuelve la posición donde queremos empezar a filtrar.
function GiveMeLineBegin () {

        BEGINLINE=$(grep -a -n "$FILTRO" $1 | cut -d: -f1 | tail -1)
#        BEGINLINE=$(expr $BEGINLINE + 1)

}

## Nos devuelve la posición donde queremos terminar de filtrar. 
function GiveMeLineEnd () {

      	let CONTDIV='1'
        FINFICHERO=$(cat $1 | wc -l)

        for (( i=$BEGINLINE+1; $i<$FINFICHERO; i++ )); do

                sed -n "$i p" $1 | grep "$APERTURADIV" > /dev/null

                if [ $? = 0 ]; then

                        CONTDIV=$(expr $CONTDIV + 1)
                fi

                sed -n "$i p" $1 | grep "$CIERRADIV" > /dev/null

                if [ $? = 0 ]; then

                        CONTDIV=$(expr $CONTDIV - 1)

                fi

                if [ $CONTDIV = 0 ]; then

                        LASTLINE=$i
                        i=$FINFICHERO

                fi

        done

#        LASTLINE=$(expr $LASTLINE - 1)


}

function leeDir () {

        for FILE in $( ls $1$EXTENSION ); do

                GiveMeLineBegin $FILE
                GiveMeLineEnd $FILE
               echo -e "Muestra fichero:\n $FILE \n Comienzo linea: $BEGINLINE --- Final Linea: $LASTLINE "
                FILENAME=$(echo $FILE | sed -r 's/(.*)\/(.*)/\2/')
#               echo $VAR
               createFile $FILE

        done

}

function createFile () {

        DIR=$(echo $DIR | sed 's/\///g')
        TITLE[0]='<title>'
        TITLE[1]='</title>'

        TITLELINEBEGIN=$(grep -a -n "${TITLE[0]}" $1 | cut -d: -f1)
        TITLELINELAST=$(grep -a -n "${TITLE[1]}" $1 | cut -d: -f1)

#echo "$TITLELINEBEGIN, $TITLELINELAST"

        TITLE[2]=$(sed -n "$TITLELINEBEGIN , $TITLELINELAST p" $1)
        TITLE[2]=$(echo ${TITLE[2]} | sed -e 's/<\/title>//g')


#echo ${TITLE[2]}

#        DESCRIPTION='<meta name="description" content="'
#        KEYWORD='<meta name="keywords" content="'

#        METADESCRIPTION=$(grep "$DESCRIPTION" $1)
#        METAKEYWORD=$(grep "$KEYWORD" $1)

	MODTITLE=$(echo ${TITLE[2]} | sed -e 's/<title>\ *//g')

        if ! [ -d "$DIR/temp" ]; then

                mkdir $DIR/temp/
        fi

        LINETEMP=$(grep -a -n 'EMPIEZA' $PLANTILLA | cut -d: -f1)
#	if [ -f "temp/$FILENAME" ]; then

	MODTITLE=$(echo $MODTITLE | tr -d '\t')
#echo "ENTRA"
	head -n$LINETEMP $PLANTILLA | sed "s/SustituirPorElTitulo/$MODTITLE/" > $DIR/temp/$FILENAME
        sed -n "$BEGINLINE,$LASTLINE p" $1 >> $DIR/temp/$FILENAME
	LINETEMP=$(grep -a -n 'TERMINA' $PLANTILLA | cut -d: -f1)
	sed -n "$LINETEMP,$ p" $PLANTILLA >> $DIR/temp/$FILENAME

#	else

#echo "ENTRA ELSE"	
#                head -n$LINETEMP $PLANTILLA | sed "s/<title> <\/title>/${TITLE[2]}<\/title>/" > $DIR/temp/$1
#                sed -n "$BEGINLINE , $LASTLINE p" $1 >> $DIR/temp/$1
#                LINETEMP=$(expr $LINETEMP + 5)
 #               sed -n "$LINETEMP , $ p" $PLANTILLA >> $DIR/temp/$1


#	fi

}


if [ -f $1 ] ; then

        GiveMeLineBegin $1
        GiveMeLineEnd $1
#	createFile $1

fi

if [ -d $1 ]; then

        DIR=$1
        leeDir $DIR

fi
