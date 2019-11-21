<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="bibliotheque.css"?>
<!--Auteurs :
 Mourad Benchikh 20034241 
 Lenny Siemeni    1055234 -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:xs="http://www.w3.org/2001/XMLSchema"
    exclude-result-prefixes="xs"
    version="2.0">
    <xsl:param name="min_price" select="0"></xsl:param>
    <xsl:param name="max_price" select="100"></xsl:param>
    <xsl:template match="bibliotheque">
        <html>
            <head>
                <meta charset="UTF-8"/> 
                <title>Bibliotheque</title>
                <link rel="stylesheet" type="text/css" href="bibliotheque.css"/>
            </head>
            <body class="corps">
                <h1 align="center" style="background-color:coral"> Listing des livres </h1>
                <table class="tab">
                    <xsl:for-each select="//livre[number(prix) &gt; $min_price and number(prix) &lt; $max_price]">
                        <!-- Tri des auteurs selon leur nom en ordre decroissant-->
                        <xsl:sort select="./@auteurs" order="descending"/>     
                        <tr>
                            <td>
                                <h3>Livre</h3>
                                <ul>
                                    <li><span class="text"> <xsl:text>Titre : </xsl:text></span> <xsl:value-of select="titre"/>
                                    </li>
                                    <li><span class="text"><xsl:text>Annee d'edition : </xsl:text></span><xsl:value-of select="annee"/>
                                    </li>
                                    <li><span class="text"><xsl:text>Prix : </xsl:text></span> <xsl:value-of select="prix"/> <xsl:value-of select="prix/@devise"/></li>
                                    <li> <span class="text"> <xsl:text>Auteur : </xsl:text> </span>
                                    <xsl:call-template name="info_auteur">
                                        <xsl:with-param name="auteur_spec" select="@auteurs"></xsl:with-param>
                                    </xsl:call-template></li>
                                </ul>
                                <img style="width:250px">
                                    <xsl:attribute name="src">
                                        <xsl:value-of select="couverture/@url"/>
                                    </xsl:attribute>
                                </img>
                                <!-- Verifie si l'element possede un commentaire puisque optionnel -->
                                <xsl:if test="commentaire">
                                    <h3>Commentaire :</h3>
                                    <p class="comment"><xsl:value-of select="commentaire"/></p>
                                </xsl:if>
                            </td> 
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
    <xsl:template name="info_auteur">
        <xsl:param name="auteur_spec"/>
        <xsl:for-each select="//auteur">
            <!-- Permet de matcher les auteurs aux bons livres -->
                <xsl:if test="contains($auteur_spec,@ident)">
                    <ul>
                        <li> <xsl:value-of select="nom"/><xsl:text> </xsl:text><xsl:value-of select="prenom"/> </li>
                    </ul>
            </xsl:if>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>