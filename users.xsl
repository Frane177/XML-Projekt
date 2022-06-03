<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
  <body>
  <h2>List of users</h2>
  <table class="table">
    <tr>
      <th>User ID</th>
      <th>UserName</th>
      <th>FirstName</th>
      <th>LastName</th>
      <th>Role</th>
    </tr>
    <xsl:for-each select="users/user">
    <tr>
      <td><xsl:value-of select="@id"/></td>
      <td><xsl:value-of select="username"/></td>
      <td><xsl:value-of select="firstname"/></td>
      <td><xsl:value-of select="lastname"/></td>
      <td><xsl:value-of select="role"/></td>
    </tr>
    </xsl:for-each>
  </table>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet> 